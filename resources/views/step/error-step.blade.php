<style>
    .dcat-done-step {
        max-width: 560px;
        margin: 0 auto;
        padding: 24px 0 8px;
    }
    .dcat-done-step .st-icon {
        color: {{ Dcat\Admin\Admin::color()->danger() }};
        font-size: 72px;
        text-align:center;
    }
    .dcat-done-step .st-content {
        text-align:center;
    }
    .dcat-done-step .st-title {
        font-size: 24px;
    }
    .dcat-done-step .st-desc {
        color: rgba(0,0,0,.5);
        font-size: 14px;
        line-height: 1.6;
    }
    .dcat-done-step .st-btn {
        margin: 30px 0 10px;
    }
</style>
<div style="margin: 0 auto">
    <div class="st-icon">
        <i class="fa fa-times-circle fa-2x"></i>
    </div>

    <div class="st-content">
        <div class="st-title">
            {{ $title }}
        </div>
        <div class="st-desc">
            {{ $description }}
        </div>

        <div class="st-btn">
            <a class="btn btn-success" href="{{ $createUrl }}" >{{ trans('admin.continue_creating') }}</a>
            &nbsp;
            <a class="btn btn-white" href="{{ $backUrl }}"><i class="fa fa-long-arrow-left"></i> {{ trans('admin.back') }}</a>
        </div>
    </div>
</div>
