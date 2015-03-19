<?php

class PageTool
{

    public static function show($url,$count,$page,$pageSize,$params=array())
    {
        $totalPage = ceil($count/$pageSize);
        $prePage = $page-1>1?$page-1:1;
        $nextPage = $page+1<$totalPage?$page+1:$totalPage;
        $url.=parse_url($url, PHP_URL_QUERY)?'&':'?';
        unset($params['page']);
        unset($params['pageSize']);
        if(!empty($params))
        {
            $url.=http_build_query($params) . '&';
        }
        $option_html = '';
        for($i=1;$i<=$totalPage;++$i)
        {
            $option_html.="<option value='{$i}' ".($i==$page?'selected':'').">{$i}</option>";
        }
        $pageHtml = <<<PAGEHTML
<table id="page-table" cellspacing="0">
                    <tbody><tr>
                        <td align="right" nowrap="true">
                            <div id="turn-page">
                                总计  <span id="totalRecords">{$count}</span>
                                个记录分为 <span id="totalPages">{$totalPage}</span>
                                页当前第 <span id="pageCurrent">{$page}</span>
                                页，每页 <input type="text" size="3" id="pageSize" value="{$pageSize}" onchange="goPage({$pageSize})">
                                <span id="page-link">
                                    <a href="javascript:goPage(1)">第一页</a>
                                    <a href="javascript:goPage({$prePage})">上一页</a>
                                    <a href="javascript:goPage({$nextPage})">下一页</a>
                                    <a href="javascript:goPage({$totalPage})">最末页</a>
                                    <select id="gotoPage" onchange="gotoPage(this.value)">
                                                                                {$option_html}
                                                                            </select>
                                </span>
                            </div>
                        </td>
                    </tr>
                </tbody></table>
            <script type="text/javascript">
                    function goPage(page)
                    {
                        var pageSize = document.getElementById("pageSize").value;
                        window.location.href="{$url}page="+page+"&pageSize="+pageSize;
                    }
                </script>
PAGEHTML;
        return $pageHtml;
    }

}
