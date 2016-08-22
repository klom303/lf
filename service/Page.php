<?php
/**
 * User: yejialu@prcsteel.com
 * Date: 16-8-12
 * Time: 下午4:12
 */
namespace Service;

class Page
{
    public static function paginate($totalNumber, $numberPerPage = 10, $currentIndex , $pageStr = 'p')
    {
        $totalPages = ceil($totalNumber / $numberPerPage);
        return self::generatePaginateStr($totalPages, $currentIndex, $pageStr);
    }

    private static function generatePaginateStr($totalPages, $currentIndex, $pageStr)
    {
        $pageClass = 'page';
        $currentClass = 'page-current';
        $prevBtnText = 'Prev';
        $nextBtnText = 'Next';
        $prevBtnState = $currentIndex > 1 ? true : false;
        $nextBtnState = $currentIndex == $totalPages ? false : true;
        $pageItem = function ($index, $text) use ($pageClass, $pageStr, $currentIndex, $currentClass) {
            if (!$index) {
                return "<a class='$pageClass' href='javascript:void(0);'>$text</a>";
            }
            if ($currentIndex == $index) {
                return "<a class='$pageClass $currentClass' href='javascript:void(0);'>$text</a>";
            }
            $_GET[$pageStr] = $index;
            $url = $_SERVER['REDIRECT_URL'] . '?' . http_build_query($_GET);
            return "<a class='$pageClass' href='$url'>$text</a>";
        };
        //不需要显示的情况
        if ($totalPages < $currentIndex || $totalPages == 1) {
            return null;
        }
        $paginateStr = $prevBtnState ? $pageItem($currentIndex - 1, $prevBtnText) : '';
        $displayIndex = 1;
        //总页数少于等于5
        if ($totalPages <= 5) {
            while ($displayIndex <= $totalPages) {
                $paginateStr .= $pageItem($displayIndex, $displayIndex);
                $displayIndex++;
            }
        }//总页数大于5
        else {
            // 1 ... 3 4 [5] 6 7 ... 9
            if ($currentIndex >= 5) {
                $paginateStr .= $pageItem(1, 1);
                $paginateStr .= $pageItem(0, '...');
                $displayIndex = $currentIndex - 2;
            }
            $middleEnd = $totalPages;
            if ($totalPages - $currentIndex > 3) {
                $middleEnd = $currentIndex + 2;
            }
            while ($displayIndex <= $middleEnd) {
                $paginateStr .= $pageItem($displayIndex, $displayIndex);
                $displayIndex++;
            }
            if ($totalPages - $currentIndex > 3) {
                $paginateStr .= $pageItem(0, '...');
                $paginateStr .= $pageItem($totalPages, $totalPages);
            }
        }
        $paginateStr .= $nextBtnState ? $pageItem($currentIndex + 1, $nextBtnText) : '';
        return $paginateStr;
    }
}