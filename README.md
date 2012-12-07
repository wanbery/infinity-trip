Infinity
========

Version 2.0.1

How to use CUFON FONT:
======================

1. Download cufon-yui.js: http://cdnjs.cloudflare.com/ajax/libs/cufon/1.09i/cufon-yui.js<br/>
2. Generate font on side: http://cufon.shoqolate.com/generate/<br/>
3. Add 'text/javascript' in layout: <br/><strong>
    &lsaquo;script src="/javascripts/cufon-yui.js" type="text/javascript"&rsaquo;&lsaquo;/script&rsaquo;<br/>
    &lsaquo;script src="/javascripts/fonts/YOUR_FONT.js" type="text/javascript"&rsaquo;&lsaquo;/script&rsaquo;<br/></strong>
4. Set for e.g. 'h1' marker:<br/><strong>
    	&lsaquo;script type=&#39;text/javascript&#39;&rsaquo;<br/>
  		Cufon.replace(&#39;h1&#39;);<br/>
	&lsaquo;/script&rsaquo;<br/></strong>
or for class:<br/><strong>
	&lsaquo;script type=&#39;text/javascript&#39;&rsaquo;<br/>
	        Cufon.replace(&#39;h1&#39;, { fontFamily: &#39;YOUR_FONT&#39; });<br/>
	        Cufon.replace(&#39;.YOUR_CLASS&#39;, { fontFamily: &#39;YOUR_FONT&#39; });<br/>
	&lsaquo;/script&rsaquo;<br/></strong>