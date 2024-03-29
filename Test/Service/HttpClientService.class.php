<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2015/4/24
 * Time: 23:01
 */

namespace Test\Service;



class HttpClientService {
    public function assertEqual(){
        return 0;
    }

    /**
     * Respose A Http Request
     *
     * @param string $url
     * @param array $post
     * @param string $method
     * @param bool $returnHeader
     * @param string $cookie
     * @param bool $bysocket
     * @param string $ip
     * @param integer $timeout
     * @param bool $block
     * @return string Response
     */
    public function httpRequest($url,$post='',$method='GET',$limit=0,$returnHeader=FALSE,$cookie='',$bysocket=FALSE,$ip='',$timeout=15,$block=TRUE) {
        $return = '';
        $matches = parse_url($url);

        !isset($matches['host']) && $matches['host'] = '';
        !isset($matches['path']) && $matches['path'] = '';
        !isset($matches['query']) && $matches['query'] = '';
        !isset($matches['port']) && $matches['port'] = '';

        $host = $matches['host'];
        $path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
        $port = !empty($matches['port']) ? $matches['port'] : 80;

        if(strtolower($method) == 'post') {
            $post = (is_array($post) and !empty($post)) ? http_build_query($post) : $post;
            $out = "POST $path HTTP/1.0\r\n";
            $out .= "Accept: */*\r\n";
            //$out .= "Referer: $boardurl\r\n";
            $out .= "Accept-Language: zh-cn\r\n";
            $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
            $out .= "Host: $host\r\n";
            $out .= 'Content-Length: '.strlen($post)."\r\n";
            $out .= "Connection: Close\r\n";
            $out .= "Cache-Control: no-cache\r\n";
            $out .= "Cookie: $cookie\r\n\r\n";
            $out .= $post;
        } else {
            $out = "GET $path HTTP/1.0\r\n";
            $out .= "Accept: */*\r\n";
            //$out .= "Referer: $boardurl\r\n";
            $out .= "Accept-Language: zh-cn\r\n";
            $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
            $out .= "Host: $host\r\n";
            $out .= "Connection: Close\r\n";
            $out .= "Cookie: $cookie\r\n\r\n";
        }

        $fp = fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);

        if(!$fp) return ''; else {
            $header = $content = '';

            stream_set_blocking($fp, $block);
            stream_set_timeout($fp, $timeout);
            fwrite($fp, $out);
            $status = stream_get_meta_data($fp);

            if(!$status['timed_out']) {//未超时
                while (!feof($fp)) {
                    $header .= $h = fgets($fp);
                    if($h && ($h == "\r\n" ||  $h == "\n")) break;
                }

                $stop = false;
                while(!feof($fp) && !$stop) {
                    $data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
                    $content .= $data;
                    if($limit) {
                        $limit -= strlen($data);
                        $stop = $limit <= 0;
                    }
                }
            }
            fclose($fp);

            return $returnHeader ? array($header,$content) : $content;
        }
    }
} 