<?php
namespace Common\View;

use Neomerx\JsonApi\Encoder\Encoder;
use Neomerx\JsonApi\Encoder\EncoderOptions;
use Neomerx\JsonApi\Encoder\Parameters\EncodingParameters;
use \Neomerx\JsonApi\Document\Link;

use System\Classes\Request;

/**
 * @codeCoverageIgnore
 */
trait JsonApiView
{

    private $links = [];
    private $meta = [];

    public function pagination(string $url, array $conditions, int $num, int $perpage, int $curpage)
    {

        unset($conditions['page']);
        //分页总数
        $pages = @ceil($num / $perpage);

        $url = !empty($conditions) ? $url.'/?'. http_build_query($conditions) : $url.'/&';
        //上一页,如果当前页数大于起始页(first), 则 $prev = 当前页数 - 1, 否则上一页 = 起始页
        //下一页,如果当前页数小于总页数, 则 $next = 当前页数 + 1,  否则下一页 = 总页数
        $prev = ($curpage > 1) ? $curpage - 1 : $curpage;
        $next = ($curpage < $pages) ? $curpage + 1 : $curpage;

        $this->links  = [
                Link::FIRST => new Link(
                    $this->getHttpHost().'/'.$url.'page[number]=1&page[size]='.$perpage,
                    null,
                    true
                ),
                Link::LAST  => new Link(
                    $this->getHttpHost().'/'.$url.'page[number]='.$pages.'&page[size]='.$perpage,
                    null,
                    true
                ),
                Link::PREV  => new Link(
                    $this->getHttpHost().'/'.$url.'page[number]='.$prev.'&page[size]='.$perpage,
                    null,
                    true
                ),
                Link::NEXT  => new Link(
                    $this->getHttpHost().'/'.$url.'page[number]='.$next.'&page[size]='.$perpage,
                    null,
                    true
                ),
        ];
        $this->meta['count'] = $num;
        return $this;
    }

    public function jsonApiFormat($object, array $objectsSchema)
    {

        $encoder = Encoder::instance(
            $objectsSchema,
            new EncoderOptions(JSON_PRETTY_PRINT, $this->getHttpHost())
        );

        return $encoder->withLinks($this->links)->withMeta($this->meta)->encodeData($object);
    }

    private function getHttpHost() : string
    {
        $request = new Request();
        return $request->getHeader('host');
    }
}
