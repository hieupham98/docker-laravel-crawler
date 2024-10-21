<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;

use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class CrawlDataFromTracnghiemOnline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public  $urls = [
        "https://tracnghiemonline.net/de-trac-nghiem-online-toan-12-giua-hoc-ki-1-de-1/",
        "https://tracnghiemonline.net/de-trac-nghiem-online-mon-toan-12-giua-hoc-ki-1-de-2/",
        "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-mon-toan-nam-2023-de-1-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-mon-toan-2023-de-2-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-toan-2023-de-3-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-online-toan-2023-de-4-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-mon-tieng-anh-nam-2023-de-1-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-tieng-anh-nam-2023-de-2-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-kiem-tra-online-tieng-anh-12-giua-ki-1-de-2/",
        // "https://tracnghiemonline.net/de-kiem-tra-online-tieng-anh-12-giua-hoc-ki-1-de-1/",
        // "https://tracnghiemonline.net/de-on-thi-tn-thpt-online-tieng-anh-nam-2023-de-3-co-goi-y-giai/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-online-tieng-anh-nam-2023-de-4-co-goi-y-giai/",
        // "https://tracnghiemonline.net/de-kiem-tra-mon-toan-12-hoc-ki-1-online-de-1/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-online-lich-su-2023-de-5-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tn-thpt-online-lich-su-2023-de-4-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-lich-su-2023-de-3-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-lich-su-nam-2023-de-2-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-mon-lich-su-nam-2023-de-1-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-mon-vat-li-nam-2023-de-1-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-vat-li-nam-2023-de-2-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-mon-ly-nam-2023-de-3-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-mon-hoa-nam-2023-de-1-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-mon-hoa-2023-de-2-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-online-mon-hoa-2023-de-3-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-online-hoa-nam-2023-de-4-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tn-thpt-online-mon-hoa-nam-2023-de-5-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-mon-dia-li-nam-2023-de-1-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-mon-dia-li-2023-de-2-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-mon-dia-2023-de-3-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-dia-li-2023-de-4-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-online-dia-li-2023-de-5-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-online-mon-dia-li-nam-2023-de-6-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-thi-thu-tot-nghiep-thpt-online-mon-dia-li-2023-de-7-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-thi-thu-tot-nghiep-thpt-online-mon-dia-2023-de-8-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-thi-thu-tot-nghiep-thpt-online-dia-li-2023-de-9-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-thi-thu-tot-nghiep-thpt-online-dia-li-nam-2023-de-10-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-thi-thu-tot-nghiep-thpt-dia-li-online-nam-2023-de-11-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-mon-sinh-nam-2023-de-1-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-mon-sinh-2023-de-2-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-sinh-hoc-2023-de-3-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-online-mon-sinh-2023-de-4-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-online-mon-sinh-nam-2023-de-5-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-gdcd-2023-de-3-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-mon-gdcd-2023-de-2-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-mon-gdcd-nam-2023-de-1-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-thpt-online-gdcd-nam-2023-de-4-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-online-gdcd-nam-2023-de-5-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-online-gdcd-2023-de-6-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tn-thpt-online-gdcd-2023-de-7-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tn-thpt-online-gdcd-nam-2023-de-8-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tn-thpt-online-mon-gdcd-nam-2023-de-9-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tn-thpt-online-mon-gdcd-2023-de-10-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-online-mon-toan-2023-de-5-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-thi-thu-tot-nghiep-online-mon-toan-2023-de-6-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-thi-thu-tot-nghiep-online-mon-toan-nam-2023-de-7-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-thi-thu-tot-nghiep-thpt-online-mon-toan-nam-2023-de-8-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-thi-thu-tot-nghiep-thpt-online-mon-toan-2023-de-9-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-thi-thu-tn-thpt-online-mon-toan-2023-de-10-co-goi-y-giai-chi-tiet/",
        // "https://tracnghiemonline.net/de-thi-mon-vat-li-12-hoc-ki-1-online-de-1/",
        // "https://tracnghiemonline.net/de-thi-vat-li-12-hoc-ki-1-online-de-2/",
        // "https://tracnghiemonline.net/de-thi-mon-hoa-12-hoc-ki-1-online-de-1/",
        // "https://tracnghiemonline.net/de-on-thi-mon-hoa-12-hoc-ki-1-online-de-2/",
        // "https://tracnghiemonline.net/de-on-thi-mon-hoa-12-hk1-online-de-3/",
        // "https://tracnghiemonline.net/de-on-thi-mon-hoa-lop-12-hk1-online-de-4/",
        // "https://tracnghiemonline.net/de-on-thi-mon-toan-12-hoc-ki-1-online-de-2/",
        // "https://tracnghiemonline.net/de-on-thi-mon-toan-12-hk1-online-co-loi-giai-de-3/",
        // "https://tracnghiemonline.net/de-on-thi-hk1-mon-toan-12-online-co-loi-giai-de-4/",
        // "https://tracnghiemonline.net/de-on-thi-hoc-ky-1-toan-12-online-co-loi-giai-de-5/",
        // "https://tracnghiemonline.net/de-kiem-tra-toan-10-hoc-ki-1-online-de-1/",
        // "https://tracnghiemonline.net/de-thi-hoc-ky-1-toan-12-online-co-loi-giai-de-6/",
        // "https://tracnghiemonline.net/de-thi-hk-1-toan-12-online-co-loi-giai-de-7/",
        // "https://tracnghiemonline.net/trac-nghiem-online-bai-15-ham-so-toan-10-ket-noi-tri-thuc-de-1/",
        // "https://tracnghiemonline.net/trac-nghiem-online-bai-15-ham-so-ket-noi-tri-thuc-de-2/",
        // "https://tracnghiemonline.net/de-kiem-tra-online-bai-15-ham-so-ket-noi-tri-thuc-de-3/",
        // "https://tracnghiemonline.net/kiem-tra-15-phut-online-bai-15-ham-so-ket-noi-tri-thuc-de-4/",
        // "https://tracnghiemonline.net/de-15-phut-online-bai-15-ham-so-ket-noi-tri-thuc-de-6/",
        // "https://tracnghiemonline.net/15-phut-online-bai-15-ham-so-ket-noi-tri-thuc-de-5/",
        // "https://tracnghiemonline.net/de-kiem-tra-15-phut-online-bai-15-ham-so-ket-noi-tri-thuc-de-7/",
        // "https://tracnghiemonline.net/trac-nghiem-online-bai-16-ham-so-bac-hai-toan-10-ket-noi-tri-thuc-de-1/",
        // "https://tracnghiemonline.net/de-trac-nghiem-online-bai-16-ham-so-bac-hai-toan-10-ket-noi-tri-thuc-de-2/",
        // "https://tracnghiemonline.net/trac-nghiem-bai-16-ham-so-bac-hai-toan-10-ket-noi-tri-thuc-de-3/",
        // "https://tracnghiemonline.net/kiem-tra-online-bai-16-ham-so-bac-hai-toan-10-ket-noi-tri-thuc-de-4/",
        // "https://tracnghiemonline.net/de-kiem-tra-online-bai-16-ham-so-bac-hai-toan-10-ket-noi-tri-thuc-de-5/",
        // "https://tracnghiemonline.net/kiem-tra-15-phut-bai-16-ham-so-bac-hai-toan-10-ket-noi-tri-thuc-de-6/",
        // "https://tracnghiemonline.net/de-kiem-tra-15-phut-bai-16-ham-so-bac-hai-toan-10-ket-noi-tri-thuc-de-7/",
        // "https://tracnghiemonline.net/kiem-tra-thuong-xuyen-bai-16-ham-so-bac-hai-toan-10-ket-noi-tri-thuc-de-8/",
        // "https://tracnghiemonline.net/de-thi-thu-tot-nghiep-thpt-online-2023-mon-toan-bam-sat-de-tham-khao-de-1/",
        // "https://tracnghiemonline.net/de-thi-thu-tot-nghiep-thpt-online-2023-mon-toan-bam-sat-minh-hoa-de-2/",
        // "https://tracnghiemonline.net/de-thi-thu-tot-nghiep-online-2023-mon-toan-bam-sat-minh-hoa-de-3/",
        // "https://tracnghiemonline.net/de-thi-thu-online-2023-mon-toan-bam-sat-minh-hoa-de-4/",
        // "https://tracnghiemonline.net/de-thi-thu-online-2023-toan-phat-trien-tu-de-minh-hoa-de-5/",
        // "https://tracnghiemonline.net/de-thi-thu-online-tot-nghiep-thpt-nam-2023-toan-bam-sat-minh-hoa-de-6/",
        // "https://tracnghiemonline.net/de-thi-thu-online-tot-nghiep-thpt-nam-2023-mon-toan-bam-sat-minh-hoa-de-7/",
        // "https://tracnghiemonline.net/de-thi-thu-tot-nghiep-2023-mon-toan-online-bam-sat-minh-hoa-de-8/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-2023-mon-toan-online-bam-sat-minh-hoa-de-9/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-2023-online-mon-toan-bam-sat-minh-hoa-de-10/",
        // "https://tracnghiemonline.net/de-luyen-thi-tot-nghiep-2023-online-mon-toan-bam-sat-minh-hoa-de-11/",
        // "https://tracnghiemonline.net/de-luyen-thi-tot-nghiep-thpt-2023-online-mon-toan-bam-sat-minh-hoa-de-12/",
        // "https://tracnghiemonline.net/de-luyen-thi-tot-nghiep-online-2023-online-mon-toan-bam-sat-minh-hoa-de-13/",
        // "https://tracnghiemonline.net/de-luyen-thi-online-2023-mon-toan-bam-sat-minh-hoa-de-14/",
        // "https://tracnghiemonline.net/de-on-thi-2023-mon-toan-online-bam-sat-minh-hoa-de-15/",
        // "https://tracnghiemonline.net/de-on-thi-tot-nghiep-online-lich-su-2024-thpt-tien-du-lan-1/",
    ];
    protected $signature = 'crawl:tracnghiemonline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */


    public function replaceBackslashes($inputArray) {
        if (!is_array(value: $inputArray)) {
            return $inputArray; // Trả lại đầu vào nếu không phải là mảng
        }
    
        // Thay thế &amp; thành & và &bsol; thành \
        return array_map(function($item) {
            $output = str_replace('&amp;', '&', $item); // Thay thế &amp; thành &
            $output = str_replace('&bsol;', '\\', $output); // Thay thế &bsol; thành \
            // Giữ lại một \ cho các \ liên tiếp
            return preg_replace('/\\\\+/', '\\', $output);
        }, $inputArray);
    }

    public function handle()
    {
         // Create an array to hold the responses
        $contents = [];

        // Loop through each URL
        foreach ($this->urls as $url) {
        // Make a GET request to the URL
            $response = Http::get($url);

            // Check if the response is successful
            if ($response->successful()) {
                $html = $response->body();
                $crawler = new Crawler($html);

                // Remove MathJax elements
                $crawler->filter('.MathJax_Preview, .mjx-chtml.MathJax_CHTML, input')->each(function ($node) {
                    $node->getNode(0)->parentNode->removeChild($node->getNode(0));
                });

                $title = $crawler->filter('h1.tdb-title-text')->text();
                $category = $crawler->filter('a.tdb-entry-crumb')->eq(1)->text();

                // Get the content of questions and answers
                $crawler->filter('div.wpProQuiz_question')->each(function ($node) use (&$contents, $url, $title, $category) {
                    $question = $node->filter('div.wpProQuiz_question_text > p')->each(function ($pNode) {
                        return trim($pNode->html());
                    });

                    $answers = $node->filter('ul.wpProQuiz_questionList > li.wpProQuiz_questionListItem > label')->each(function ($labelNode) {
                        return trim($labelNode->html());
                    });

                    $contents[$url][] = [
                        'title' => $title,
                        'url' => $url,
                        'category' => "(Crawler)" . $category,
                        'question' => $this->replaceBackslashes($question),
                        'answers' => $this->replaceBackslashes($answers),
                    ];
                });

            } else {
                // Handle error
                $contents[] = [
                    'url' => $url,
                    'error' => 'Failed to fetch',
                ];
            }

            $this->info("Crawl succeed: $url");
        }

        $jsonContent = json_encode($contents);
        $filePath = 'exports/exams.json';
        Storage::disk('local')->put($filePath, $jsonContent);


        return Command::SUCCESS;
    }
}
