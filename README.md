Infinity
========

Version 2.0.1

How to use CUFON FONT:
======================

1. Download cufon-yui.js: http://cdnjs.cloudflare.com/ajax/libs/cufon/1.09i/cufon-yui.js
2. Generate font on side: http://cufon.shoqolate.com/generate/
3. Add 'text/javascript' in layout: 
    <script src="/javascripts/cufon-yui.js" type="text/javascript"></script>
    <script src="/javascripts/fonts/YOUR_FONT.js" type="text/javascript"></script>
4. Set for e.g. 'h1' marker:
    <script type="text/javascript">
  		Cufon.replace('h1');
	  </script>
or for class:
    <script type=”text/javascript”>
      Cufon.replace(‘h1′, { fontFamily: ‘YOUR_FONT′ });
      Cufon.replace(‘.YOUR_CLASS’, { fontFamily: ‘YOUR_FONT′ });
    </script>