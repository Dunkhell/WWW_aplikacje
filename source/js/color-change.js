var computed = false;
var decimal = 0;

function convert (entryform, from, to)
{
    convertfrom = from.selectedIndex;
    convertto = to.selectedIndex;
    entryform.display.value = (entryform.input.value*from[convertfrom].value / to[convertto].value)
}
function addchar (input, character)
{
    if((character=='.' && decimal=="0") || character!='.')
    {
        (input.value = "" || input.value == "0") ? input.value = character : input.value += character
        convert(input.form,input.form.measurel, input.form.measure2)
        computed = true ;
        if (character=='.')
        {
            decimal = 1;
        }
    }
}
function openvothcom()
{
    window.open("","Display window" , "toolbar=no,directories=no,menubar=no")
}
 function clear (form)
 {
    form, input, value = 0;
    form, display, value = 0;
    decimal=0;
 }

 // to be trully honest I haven't got a single clue of what the above functions aim to accomplish so I didn't bother changing their variable names or function names, left 
 // them as they were 
function changeBackground(hexNumber)
{


    if (hexNumber == '#212121' || hexNumber == '#c0c0c0') {
        document.body.style.color = "white";
        document.body.style.backgroundColor = hexNumber;
    } else if (hexNumber == "#FFFFFF") {
        document.body.style.color = "black"
        document.body.style.backgroundColor = hexNumber;

    } else {
        console.error("Invalid hexNumber in changeBackground method");
    }
}