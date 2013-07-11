
$(document).ready(function() {

	$(this).addWebForms();
    
	// collapsable headers
	$('thead.collapsable', this).each(function() {
	    var $thead = $(this);
	    if ($thead.find('.block_collapse_btn').length)
            return;

        var sIconName = $thead.hasClass('collapsed') ? 'caret-right' : 'caret-down';
	    $('<i class="block_collapse_btn sys-icon ' + sIconName + '" />')
	        .prependTo($('th',$thead))
	        .click(function() {
	            if ($thead.hasClass('collapsed')) {
	                // show
                    $(this).removeClass('caret-right').addClass('caret-down');
	                $thead.removeClass('collapsed').next('tbody').fadeIn(400);
	            } else {
	                // hide
                    $(this).removeClass('caret-down').addClass('caret-right');
	                $thead.addClass('collapsed').next('tbody').fadeOut(400);
	            }
	        });
	});
});

(function($){
    $.fn.addWebForms = function() {
		$("input,select,textarea", this).each(function() {

			// Date/Time pickers
			if (this.getAttribute("type") == "date" || this.getAttribute("type") == "date_calendar" || this.getAttribute("type") == "datetime" || this.getAttribute("type") == "date_time" ) {
                var iYearMin = '1900';
                var iYearMax = '2100';
                var a;

                if ($(this).attr('min') && (a = $(this).attr('min').split('-')) && a.length)
                    iYearMin = a[0];
                if ($(this).attr('max') && (a = $(this).attr('max').split('-')) && a.length)
                    iYearMax = a[0];

                if (this.getAttribute("type") == "date" || this.getAttribute("type") == "date_calendar") { // Date picker

                    $(this).datepicker({
                        changeYear: true,
                        changeMonth: true,
                        dateFormat: 'yy-mm-dd',
                        defaultDate: '-22y',
                        yearRange: iYearMin + ':' + iYearMax 
                    });

                } else if(this.getAttribute("type") == "datetime" || this.getAttribute("type") == "date_time") { // DateTime picker

                    $(this).datetimepicker({                        
                        changeYear: true,
                        changeMonth: true,
                        dateFormat: 'yy-mm-dd'
                    });
                }

                if (window.navigator.appVersion.search(/Chrome\/(.*?) /) == -1 || parseInt(window.navigator.appVersion.match(/Chrome\/(\d+)\./)[1], 10) < 24)
                    if( this.getAttribute("allow_input") == null)
                        $(this).attr('readonly', 'readonly');

			}
			

			// Multiplyable
			if (this.getAttribute('multiplyable') == 'true') {
			   $(this).multiplyable();
			}
			
			if (this.getAttribute('deletable') == 'true') {
			    $(this).inputDeletable();
			}
			
			// Counter for textareas
            if (this.getAttribute('counter') == 'true') {
                
                function updateCounter() {
                    if( $area.val() )
                        $counter.show( 300 );
                    else
                        $counter.hide( 300 );
                    
                    $counterCont.html( $area.val().length );
                }
                
                var $area = $(this);
                $area
                .parents('td:first')
                    .append(
                        '<div class="counter" style="display:none;">' + _t('_Counter') + ': <b></b></div>' +
                        '<div class="clear_both"></div>'
                    );
                
                var $counter     = $area.parent().parent().children('div.counter');
                
                var $counterCont = $counter.children('b');
                
                updateCounter();
                $area.change( updateCounter ).keyup( updateCounter );
            }
			
            // DoubleRange
            if(this.getAttribute("type") == "doublerange" || this.getAttribute("type") == "slider" || this.getAttribute("type") == "range") {
			    
				var cur = $(this);
				
				var $slider = $("<div></div>").insertAfter(cur);
				
				$slider.addClass(cur.attr('class'));
				
				cur.css({ position: "absolute", opacity: 0, top: "-1000px", left: "-1000px" });
				
				var iMin = cur.attr("min") ? parseInt(cur.attr("min"), 10) : 0;
				var iMax = cur.attr("max") ? parseInt(cur.attr("max"), 10) : 100;
				var sRangeDv = cur.attr("range-divider") ? cur.attr("range-divider") : '-';

                var oOptions = {
                    range: cur.attr("type") == "doublerange" ? true : false,
					min: iMin,
					max: iMax,
					step: parseInt(cur.attr("step")) | 1,
					change: function(e, ui) {
                        if (cur.attr("type") == "doublerange")
					        cur.val( ui.values[0] + sRangeDv + ui.values[1] );
                        else
                            cur.val( ui.value );

					    if(typeof(cur.attr("onchange")) != 'undefined' && cur.attr("onchange").length)
					    	eval(cur.attr("onchange"));
					},
					slide: function(e, ui) {
					    $(ui.handle).html(ui.value);
					}
				};

                var values;
                if (cur.attr("type") == "doublerange") {
                    values = cur.val().split(sRangeDv, 2); // get values
                    
                    if (typeof(values[0]) != 'undefined' && values[0].length)
                        values[0] = parseInt(values[0]);
                    else
                        values[0] = iMin;
                    
                    if (typeof(values[1]) != 'undefined' && values[1].length)
                        values[1] = parseInt(values[1]);
                    else
                        values[1] = iMax;

                    oOptions['values'] = values;
                } else {
                    oOptions['value'] = cur.val();
                }

				$slider.slider(oOptions);
				                
                $('.ui-slider-handle', $slider).each(function(i){
                    if (cur.attr("type") == "doublerange")
                        $(this).html(values[i]);
                    else
                        $(this).html(cur.val());
                });

			}
		});
        return this;
    };
    
    $.fn.inputDeletable = function(oDeleteAlso) {        
        return $(this).each( function() {
            var $eInput = $(this);

            // insert "Remove" button
            var $minusImg = $('<i class="multiply_remove_button sys-icon minus-sign" alt="Remove" title="Remove"></i>')
            .click( function() {
                var eParent = $eInput.parent(':not(td)');
                
                $(this).remove(); // remove button
                $eInput.remove(); // remove input
                eParent.remove(); // remove parent (if present)
                
                if (typeof oDeleteAlso != 'undefined')
                    $(oDeleteAlso).remove();
                
                // Note: Do not delete parent only. It is present not everytime
            })
            .insertAfter($eInput.parent());
        });
        
        return this;
    };
    
    $.fn.multiplyable = function() {
        $(this).each(function() {
            var $input = $(this);
            var $inputParent = $input.parent();
            var $wrapper = $inputParent.clone().children().remove().end();
            
            // insert "Other" button
            if ($input.attr('add_other') == 'true' && !$inputParent.parent().find('.multiply_other_button').length) {
                var $otherImg = $('<i class="multiply_other_button sys-icon folder-close" alt="Add other" title="Add other"></i>')
                .insertAfter($inputParent)
                .click(function(){
                    var $trc = $($inputParent).nextAll('div.clear_both:last');
                    $trc = $trc.length ? $trc : $inputParent; // just if div.clear_both doesn't exist
                    
                    var $clearBoth = $('<div class="clear_both"></div>').insertAfter($trc);
                    
                    $wrapper
                    .clone()
                        .append('<input type="text" class="form_input_text" name="' + $input.attr('name') + '" />')
                        .insertAfter($trc)
                        .children(':first')
                            .inputDeletable($clearBoth)
                            .get(0)
                                .focus();
                });
            }
            
            // check if "Add" button is already added
            if ($inputParent.parent().find('.multiply_add_button').length)
                return;

            // insert "Add" button
            var $plusImg = $('<i class="multiply_add_button sys-icon plus-sign" alt="Add" title="Add"></i>')
            .insertAfter($inputParent)
            .click(function(){
                var $trc = $($inputParent).nextAll('div.clear_both:last');
                $trc = $trc.length ? $trc : $inputParent; // just if div.clear_both doesn't exist
                
                var $clearBoth = $('<div class="clear_both"></div>').insertAfter($trc);
                
                $inputParent
                .clone()
                    .children()
                        .removeAttr('id') // TODO: set unique id
                    .end()
                    .each(function(){
                        var $input = $('input', this);
                        if ($input.length && ($input.attr('type') == 'file' || $input.attr('type') == 'text'))
                            $input.val('');
                    })
                    .insertAfter($trc)
                    .children(':first')
                        .inputDeletable($clearBoth)
                        .get(0)
                            .focus();
            });
        });
        
        return this;
    };
})(jQuery);


(function($){
    $.fn.formsToggleHtmlEditor = function() {
		$(this).each(function() {
            if ($(this).is(':hidden'))
                tinyMCE.execCommand('mceRemoveControl', false, this.id);
            else
                tinyMCE.execCommand('mceAddControl', false, this.id);
                
        });
        return this;
    };
})(jQuery);

