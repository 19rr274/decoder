


   var editor = CodeMirror.fromTextArea(document.getElementById('code'), {
    lineNumbers: true,
    theme: 'monokai'
});

$.ajaxSetup({   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}    });
        
        function runpro() 
        {
            document.getElementById("inputdiv").style.display = "none";
            document.getElementById("output").innerHTML = "Running...";
            
            var data = {
            'code': editor.getValue(),
            'input': document.getElementById("inputarea").value,
            'compilerId' : document.getElementById("compiler").value,
            };
    
            $.ajax({
                url: '/runpro',
                type: 'POST',
                data: data,
                success: function(response) {
                document.getElementById("output").innerHTML = response;
                }
            })
        }
    
    
        function rundebug() 
        {
            const val_box = document.getElementById("valbox");
            val_box.setAttribute("value", "Calculating...");
            var val_label= "Value of " + document.getElementById("val").value + " at line " +document.getElementById("line").value;
            var data = {
                'code': editor.getValue(),
                'input': document.getElementById("inputarea").value,
                'line': document.getElementById("line").value,
                'val' :document.getElementById("val").value
            };
            console.log(data);
            $.ajax({
                url: '/find',
                type: 'POST',
                data: data,
                success: function(response) {   
                    document.getElementById("val_label").innerHTML = val_label; 
                    val_box.setAttribute("value", response);
                }
            })
    
    
        }
    
        $( ".compiler" ).change(function() {
        
    
            var val_compilerId = document.getElementById("compiler").value;
            console.log(val_compilerId);
        if(val_compilerId=='1')
        {
            document.getElementById("debugButton").style.display = "block"; 
        }
        else{
            document.getElementById("debugButton").style.display = "none"; 
        }
        });
    
        function hidedebug()    { document.getElementById("debugbar").style.display = "none";   }
        function showdebug()    { document.getElementById("debugbar").style.display = "inline";  }
        function hideinput()    { document.getElementById("inputdiv").style.display = "none";   }
        function showinput()    { document.getElementById("inputdiv").style.display = "block";  }
    
    