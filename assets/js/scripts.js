(function(window, undefined) {
  'use strict';

  	$(document).ready(function() {
  		//alert("Datatables");
        window.prettyPrint() && prettyPrint();
        

        
        $('select.multiselect').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true
        });
	});

  /*
  NOTE:
  ------
  PLACE HERE YOUR OWN JAVASCRIPT CODE IF NEEDED
  WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR JAVASCRIPT CODE PLEASE CONSIDER WRITING YOUR SCRIPT HERE.  */

})(window);