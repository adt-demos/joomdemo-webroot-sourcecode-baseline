<?php

/**
-------------------------------------------------------------------------
wallfactory - Wall Factory 4.1.8
-------------------------------------------------------------------------
 * @author thePHPfactory
 * @copyright Copyright (C) 2011 SKEPSIS Consult SRL. All Rights Reserved.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * Websites: http://www.thePHPfactory.com
 * Technical Support: Forum - http://www.thePHPfactory.com/forum/
-------------------------------------------------------------------------
*/

defined('_JEXEC') or die;

class JFormFieldBookmarkLink extends JFormFieldText
{
    protected function getInput()
    {
        $html = array();

        $html[] = parent::getInput();

        $html[] = <<<HTML
<ul>
    <li>
        <a href="#" data-token="{{ url }}">{{ url }}</a> - Post url
    </li>
    
    <li>
        <a href="#" data-token="{{ title }}">{{ title }}</a> - Post title
    </li>
</ul>

<script>
    jQuery(document).ready(function($) {
        $.fn.getCursorPosition = function () {
            var el = $(this).get(0);
            var pos = 0;
            if ('selectionStart' in el) {
                pos = el.selectionStart;
            } else if ('selection' in document) {
                el.focus();
                var Sel = document.selection.createRange();
                var SelLength = document.selection.createRange().text.length;
                Sel.moveStart('character', -el.value.length);
                pos = Sel.text.length - SelLength;
            }
            return pos;
        }
        
        $.fn.setCursorPosition = function(pos) {
            this.each(function(index, elem) {
                if (elem.setSelectionRange) {
                    elem.setSelectionRange(pos, pos);
                } else if (elem.createTextRange) {
                    var range = elem.createTextRange();
                    range.collapse(true);
                    range.moveEnd('character', pos);
                    range.moveStart('character', pos);
                    range.select();
                }
            });
          return this;
        };
        
        $('a[data-token]').click(function (event) {
            event.preventDefault();
            
            var position = $('#jform_link').getCursorPosition();
            var content = $('#jform_link').val();
            var newContent = content.substr(0, position) + $(this).data('token') + content.substr(position);
            
            $('#jform_link').val(newContent);
            $('#jform_link').focus().setCursorPosition(position + $(this).data('token').length);
        });
    });
</script>
HTML;
        return implode($html);
    }

}
