<div id="bxwall">
    <div class="wall-view">
        <div class="wall-timeline">
            <?=$a['timeline'];?>
        </div>
        <div class="wall-events">
            <?=$a['content'];?>
        </div>
    </div>
    <!-- Is used with common Pagination -->
    <!-- <?=$this->parseSystemKey('paginate', $mixedKeyWrapperHtml);?> -->
    <script language="javascript" type="text/javascript">
    <!--
        <?=$a['view_js_content'];?>
    -->
    </script>
</div>