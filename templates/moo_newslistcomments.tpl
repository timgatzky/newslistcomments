<script type="text/javascript">
/* <![CDATA[ */

/**
 * Create Accordion
 */
window.addEvent('domready', function()
{
new Accordion($$('div.newscomments_toggler'), $$('div.newscomments_accordion'), {
      opacity: false,
      display: false,
      alwaysHide: true,
      onActive: function(tog, el) {
        el.setProperty('aria-hidden', 'false');
        tog.addClass('active');
        tog.getNext('div').fade('in');
        tog.setProperty('aria-expanded', 'true');
        return false;
      },
      onBackground: function(tog, el) {
        el.setProperty('aria-hidden', 'true');
        tog.removeClass('active');
        tog.getNext('div').fade('out');
        tog.setProperty('aria-expanded', 'false');
        return false;
      }
    });
    
    $$('div.newscomments_toggler').each(function(el) {
      el.setProperty('role', 'tab');
      el.setProperty('tabindex', 0);
      el.addEvents({
        'keypress': function(event) {
          if (event.code == 13) {
            this.fireEvent('click');
          }
        },
        'focus': function() {
          this.addClass('hover');
        },
        'blur': function() {
          this.removeClass('hover');
        },
        'mouseenter': function() {
          this.addClass('hover');
        },
        'mouseleave': function() {
          this.removeClass('hover');
        }
      });
    });
    $$('div.ce_accordion').each(function(el) {
      el.setProperty('role', 'tablist');
    });
    $$('div.accordion').each(function(el) {
      el.setProperty('role', 'tabpanel');
    });
});


/**
 * Set Focus on textfield and clear default value when clicked on "new comment" element
 */
window.addEvent('domready', function() 
{
	var arrElems = $$('div.commentslist' );
	var arrHandlers = arrElems.getElements('.new_comment');
	var arrTextfields = arrElems.getElement('input.text');
	
	var defaultText = '<?php echo $GLOBALS['TL_LANG']['newslistcomments']['comment_default']; ?>';
	var currText = "";
	var last;
	var lastIndex;
	var lastTextfield;
	
	arrElems.each(function(key, index) {
		var handler = arrHandlers[index];
		handler.addEvents({
			'click' : function(e)
			{
				if(e.target == last || last == undefined)
				{
					var curr = arrTextfields[index];
					currText = curr.get('value');
					curr.set('value', '');
					curr.addClass('focus');
					curr.focus();
					
					last = e.target;
					lastIndex = index;
				}
				else
				{
					// reset last textfield if value has not changed
					var old = arrTextfields[lastIndex];
					var text = old.get('value');
					if(text == "") old.set('value', defaultText);
					old.removeClass('focus');
					
					var curr = arrTextfields[index];
					defaultText = curr.get('value');
					curr.set('value', '');
					curr.addClass('focus');
					curr.focus();
					
					last = e.target;
					lastIndex = index;
				}
			}
		});
		
		// clear default when clicked in side textfield
		var textfield = arrTextfields[index];
		textfield.addEvents({
		   'click' : function(e)
		   {
		   		currText = this.get('value');
		   		if(currText == defaultText)
		   			this.set('value', '');
		   		this.addClass('focus');
		   		
		   		last = this;
		   		lastIndex = index;
		   }
		});
	});
	
	// add click event to body for releaseoutside trigger
	document.body.addEvent('click', function(e) 
	{
		if(e.target != last && last != undefined)
		{
			var curr = arrTextfields[lastIndex];
			var text = curr.get('value');
			if(text == "") curr.set('value', defaultText);
			curr.removeClass('focus');
		}
		
	});
});


/* ]]> */
</script>
