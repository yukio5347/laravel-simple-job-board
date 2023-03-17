<?php

namespace App\Console\Commands;

use App\Models\JobPosting;
use Illuminate\Console\Command;

class GenerateSitemaps extends Command
{
    const PER_PAGE = 50000;

    const HEADER = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
';

    const FOOTER = '</urlset>';

    /**
     * Path to sitemap
     *
     * @var string
     */
    private string $path;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemaps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemaps';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->path = public_path('sitemaps');
        $this->createDirectory();
        $this->deleteSitemaps();
        $this->generatePagesSitemap();
        $this->generateJobSitemaps();
        $this->generateSitemapIndex();
        $this->info('done.');
    }

    /**
     * Create directory
     *
     * @return void
     */
    private function createDirectory(): void
    {
        if (! file_exists($this->path)) {
            mkdir($this->path, 0755, true);
        }
    }

    /**
     * Delete all sitemaps
     *
     * @return void
     */
    private function deleteSitemaps(): void
    {
        foreach (glob("{$this->path}/*.xml") as $sitemap) {
            unlink($sitemap);
        }
    }

    /**
     * Generate a sitemap for static pages
     *
     * @return void
     */
    private function generatePagesSitemap(): void
    {
        $fp = fopen("{$this->path}/pages.xml", 'w');
        fwrite($fp, self::HEADER);
        fwrite($fp, "    <url><loc>" . route('home') . "</loc></url>\n");
        fwrite($fp, "    <url><loc>" . route('jobs.index') . "</loc></url>\n");
        fwrite($fp, "    <url><loc>" . route('jobs.create') . "</loc></url>\n");
        fwrite($fp, "    <url><loc>" . route('contact') . "</loc></url>\n");
        fwrite($fp, self::FOOTER);
        fclose($fp);
        $this->info("{$this->path}/pages.xml generated.");
    }

    /**
     * Generate sitemaps for job detail pages
     *
     * @return void
     */
    private function generateJobSitemaps(): void
    {
        $count = 0; // job count for a sitemap
        $num = 1; // sitemap serial number
        $fp = $this->getFileStream($num);
        foreach (JobPosting::select('id')->active()->lazyById() as $jobPosting) {
            // Go on next sitemap
            if ($count >= self::PER_PAGE) {
                fwrite($fp, self::FOOTER);
                fclose($fp);
                $num++;
                $fp = $this->getFileStream($num);
                $count = 0;
            }
            fwrite($fp, "    <url><loc>" . route('jobs.show', $jobPosting) . "</loc></url>\n");
            $count++;
        }
        fwrite($fp, self::FOOTER);
    }

    /**
     * Get stream resource
     *
     * @param integer $num
     * @return void
     */
    private function getFileStream(int $num)
    {
        $num = sprintf('%02d', $num);
        $path = "{$this->path}/jobs{$num}.xml";
        $fp = fopen($path, 'w');
        $this->info("{$path} generated.");
        fwrite($fp, self::HEADER);

        return $fp;
    }

    /**
     * Generate sitemap index file
     *
     * @return void
     */
    private function generateSitemapIndex(): void
    {
        $sitemaps = glob("{$this->path}/*.xml");
        $fp = fopen("{$this->path}/index.xml", 'w');
        fwrite($fp, '<?xml version="1.0" encoding="UTF-8"?>
    <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
');
        foreach ($sitemaps as $sitemap) {
            $file = str_replace($this->path, 'sitemaps', $sitemap);
            fwrite($fp, "    <sitemap><loc>" . url($file) . "</loc></sitemap>\n");
        }

        fwrite($fp, '</sitemapindex>');
        fclose($fp);
        $this->info('sitemap index generated.');
    }
}
