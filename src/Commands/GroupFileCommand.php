<?php

namespace Tubocms\GroupFile\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use DB;

class GroupFileCommand extends Command {

    protected $signature = 'tubocms:groups';

    protected $description = 'Gộp các file được cấu hình tại config';

    public function handle() {
    	$configs = config('TuboGroupFile.generate');
        foreach ($configs as $item) {
            // Nội dung file
            $content = '';
            // Foreach lấy các link file muốn gộp
            foreach ($item['files'] as $file) {
                // Kiểm tra vị trí của link
                if ($file['type'] == 'config') {
                    // Nếu link được cấu hình lấy từ config
                    $link = config($file['link']);
                } else {
                    // Nếu link được cấu hình lấy từ file
                    $link = $file['link']??'';
                }
                // Nếu link khác rỗng
                if ($link != null) {
                    $parse_link = parse_url($link);
                    try {
                        // Nếu trong link chứa http hay https thì là link online => không cần thêm domain
                        // Nếu không có thì sẽ hiểu là link file và thêm domain trước link
                        if (isset($parse_link['scheme']) && in_array($parse_link['scheme'], ['http', 'https'])) {
                            $content .= file_get_contents($link);
                        } else {
                            $content .= file_get_contents(\Request::root().$link);
                        }
                    } catch (\Exception $e) {
                        \Log::error($e);
                    }
                }
            }
            \Storage::disk('local')->put($item['file_path'], "\xEF\xBB\xBF" . $content);
        }
        $this->echoLog('Group File Success.');
    }

    public function echoLog($string, $type = 'info') {
        $this->info($string);
        switch ($type) {
            case 'info':
                Log::info($string);
            break;
            case 'warning':
                Log::warning($string);
            break;
            case 'error':
                Log::error($string);
            break;
        }
    }

}