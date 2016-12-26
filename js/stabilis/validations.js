if(Validation) {
    
    Validation.addAllThese([
        ['validate-modern-css-length', 
         'Please enter a valid CSS length', 
         function(value) {
             switch(value) {
                 case '':
                 case '0':
                 case 'auto':
                 case 'inherit':
                 case 'initial':
                     return true;
                 default:
                     return /^[+-]?(\d*\.)?\d+(%|ch|cm|ex|in|mm|px|pc|pt|r?em|vh|vmax|vmin|vw)$/i.test(value);
             }
         }]
         ///...more validators to follow
    ]);
}