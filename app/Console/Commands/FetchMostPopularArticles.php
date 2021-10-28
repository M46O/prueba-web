<?php

namespace App\Console\Commands;

use App\Models\Article;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class FetchMostPopularArticles extends Command
{
    const BASE_URL = 'https://api.nytimes.com/svc/mostpopular/v2';

    const EMAILED = 'emailed';
    const SHARED = 'shared';
    const VIEWED = 'viewed';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:most-popular-articles {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get a list of most popular articles in New York Times';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $typeFetch = $this->argument('type');

        try {
            DB::beginTransaction();

            $response = Http::get(self::BASE_URL . "/$typeFetch/1.json", ['api-key' => config('nyt.key')]);

            $results = $response->throw()->json()['results'];

            foreach ($results as $result) {
                $article = Article::query()->firstOrNew(['uid' => $result['id']]);

                $article->title = $result['title'];
                $article->url = $result['url'];
                $article->abstract = $result['abstract'];
                $article->byline = $result['byline'];

                $article->save();

                if (isset($result['media'][0]['media-metadata'])) {
                    $article->images()->createMany($result['media'][0]['media-metadata']);
                }
            }

            DB::commit();

            return Command::SUCCESS;
        } catch (Exception $e) {
            $this->error("Failed Fetch error:" . $e->getMessage());

            DB::rollBack();

            return Command::FAILURE;
        }
    }
}
