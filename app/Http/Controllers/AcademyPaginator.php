<?php


namespace App\Http\Controllers;


use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator as BasePaginator;

class AcademyPaginator extends BasePaginator
{

    //声明分页URL的变量
    protected $pageUrl = '';

   //声明分页URL的尾缀
    protected $ext = '';

    /**
     * 重写页面 URL 实现代码，去掉分页中的问号，实现伪静态链接
     * @param int $page
     * @return string
     */
    public function url($page)
    {
        if ($page <= 0) {
            $page = 1;
        }

        // 移除路径尾部的/
        $path = rtrim($this->path, '/');

        // 如果路径中包含分页信息则正则替换页码，否则将页码信息追加到路径末尾
        if (preg_match('/\/page\/\d+/', $path)) {
            $path = preg_replace('/\/page\/\d+/', '/page/' . $page, $path);
//            $path = preg_replace('/\/page\/\d+/', '_' . $page, $path);
        } else {
            $path .= '/page/' . $page;
//            $path .= '_' . $page;
        }
        $this->path = $path;

        if ($this->query) {
            $url = $this->path . (Str::contains($this->path, '?') ? '&' : '?')
                . http_build_query($this->query, '', '&')
                . $this->buildFragment();
        } elseif ($this->fragment) {
            $url = $this->path . $this->buildFragment();
        } else {
            $url = $this->path;
        }
        return $url;
    }

    //url预加载
    public function withUrl($str,$ext)
    {
        $this->urlStr = $str;
        $this->ext = $ext;
        return $this;
    }

    /**
     * 重写当前页设置方法
     *
     * @param int $currentPage
     * @param string $pageName
     * @return int
     */
    protected function setCurrentPage($currentPage, $pageName)
    {
        if (!$currentPage && preg_match('/\/page\/(\d+)/', $this->path, $matches)) {
            $currentPage = $matches[1];
        }

        return $this->isValidPageNumber($currentPage) ? (int)$currentPage : 1;
    }

    /**
     * 将新增的分页方法注册到查询构建器中，以便在模型实例上使用
     * 注册方式：
     * 在 AppServiceProvider 的 boot 方法中注册：AcademyPaginator::rejectIntoBuilder();
     * 使用方式：
     * 将之前代码中在模型实例上调用 paginate 方法改为调用 seoPaginate 方法即可：
     * Article::where('status', 1)->seoPaginate(15, ['*'], 'page', page);
     */
    public static function injectIntoBuilder()
    {
        /*
         * $perPage 每页显示多少条
         * $columns 查询的字段
         * $pageName 翻页链接的参数名
         * $page 当前页数
         * */
        Builder::macro('seoPaginate', function ($perPage, $columns, $pageName, $page) {
            $perPage = $perPage ?: $this->model->getPerPage();

            $items = ($total = $this->toBase()->getCountForPagination())
                ? $this->forPage($page, $perPage)->get($columns)
                : $this->model->newCollection();

            $options = [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ];

            return Container::getInstance()->makeWith(AcademyPaginator::class, compact(
                'items', 'total', 'perPage', 'page', 'options'
            ));
        });
    }
}