<div class="adm-dashboard-stats">
    
    <div class="adm-ds-important">
        <?php if(is_array($a['bx_repeat:items_important'])) for($i=0; $i<count($a['bx_repeat:items_important']); $i++){ ?>
            <div class="adm-ds-item">
                <?php if($a['bx_repeat:items_important'][$i]['bx_if:show_link']['condition']){ ?>
                    <a href="<?=$a['bx_repeat:items_important'][$i]['bx_if:show_link']['content']['link'];?>"><span class="bx-def-font-h1"><?=$a['bx_repeat:items_important'][$i]['bx_if:show_link']['content']['number'];?></span> <?=$a['bx_repeat:items_important'][$i]['bx_if:show_link']['content']['caption'];?></a>
                <?php } ?>
                <?php if($a['bx_repeat:items_important'][$i]['bx_if:show_text']['condition']){ ?><span class="bx-def-font-h1"><?=$a['bx_repeat:items_important'][$i]['bx_if:show_text']['content']['number'];?></span> <?=$a['bx_repeat:items_important'][$i]['bx_if:show_text']['content']['caption'];?><?php } ?>
            </div>
        <?php } else if(is_string($a['bx_repeat:items_important'])) echo $a['bx_repeat:items_important']; ?>
    </div>

    <div class="clear_both"></div>

    <div class="bx-def-hr bx-def-margin-sec-top bx-def-margin-sec-bottom"></div>

    <div class="adm-ds-common">
        <?php if(is_array($a['bx_repeat:items_common'])) for($i=0; $i<count($a['bx_repeat:items_common']); $i++){ ?>
            <div class="adm-ds-item">
                <?php if($a['bx_repeat:items_common'][$i]['bx_if:show_link']['condition']){ ?>
                    <a href="<?=$a['bx_repeat:items_common'][$i]['bx_if:show_link']['content']['link'];?>"><span class="bx-def-font-h1"><?=$a['bx_repeat:items_common'][$i]['bx_if:show_link']['content']['number'];?></span> <?=$a['bx_repeat:items_common'][$i]['bx_if:show_link']['content']['caption'];?></a>
                <?php } ?>
                <?php if($a['bx_repeat:items_common'][$i]['bx_if:show_text']['condition']){ ?><span class="bx-def-font-h1"><?=$a['bx_repeat:items_common'][$i]['bx_if:show_text']['content']['number'];?></span> <?=$a['bx_repeat:items_common'][$i]['bx_if:show_text']['content']['caption'];?><?php } ?>
            </div>
        <?php } else if(is_string($a['bx_repeat:items_common'])) echo $a['bx_repeat:items_common']; ?>
        <div class="clear_both"></div>        
    </div>


    <div id="adm-ds-common-chart" class="bx-def-border"></div>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script>
        
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(bx_stat_show_chart);

        function bx_stat_show_chart () {
            var data = google.visualization.arrayToDataTable([
                ['Content', 'Count'] <?=$a['common_chart_data'];?>
            ]);

            var options = {};

            var chart = new google.visualization.PieChart($('#adm-ds-common-chart')[0]);
            chart.draw(data, options);
        }

    </script>

    <div class="clear_both"></div>        

</div>
