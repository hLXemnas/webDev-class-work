var anim = false;
var up = 1;
var down = 1;
var squareCount = parseInt(Math.random() * 21 + 30);
$(document).ready(function(){
	$("#animate").click(function(){
		$(".square").each(function(){
			$this = $(this);
			anim = true;
			var speed = calcSpeed();
			if((Math.random()*100)%2 == 0){
				up = 1;
				down = 1;
				if(((Math.random()*100)%2) == 0){
					up=-1;
		}
			}
			else{
			up = -1;
			down = -1;
			if(((Math.random()*100)%2) == 0){
					down=1;
				}
		}
			animateDiv($this, up, down, speed);
		});
	});
	$("#stop").click(function(){
		$(".square").stop();
		 anim = false;
	})
	$("#add").click(function(){
		var squareArea = $("#squareArea");
		var square     = $("<div>");
		var width      = parseInt(squareArea.clientWidth)-50;

		square.addClass("square");
		square.css("left",parseInt(Math.random() * 550) + "px" );
		square.css("top",parseInt(Math.random() * 420) + "px");
		square.css("backgroundColor", getRandomColor());

		squareArea.append(square);
		if(anim == true){
			animateDiv(square, 1, 1);
		}
	});
	$("#colors").click(function(){
		
		$(".square").each(function(){
			this.style.backgroundColor = getRandomColor();
		});
	});
	$("#reset").click(function(){
		var area = $("#squareArea");
		while(squareArea.firstChild) {
    	squareArea.removeChild(squareArea.firstChild);
		}
		for(var i=0; i<squareCount; i++){
		addSquare();
		}
	});

	for(var i=0; i<squareCount; i++){
		addSquare();
	}
	$(".square").click(function(){
		circ = $(this);
		$(circ).css("z-index", 1000);
	});

	$(".square").dblclick(function(){
		this.parentNode.removeChild(this);
	});
	
});
function resetSquares(){
	var squareArea = document.getElementById("squareArea");
	
	var myNode = document.getElementById("squareArea");
	while(myNode.firstChild) {
    	myNode.removeChild(myNode.firstChild);
	}

	for(var i=0; i<squareCount; i++){
		addSquare();
	}
}
function addSquare(){
	var squareArea = $("#squareArea");
	var square     = $("<div>");
	var width      = parseInt(squareArea.clientWidth)-200;
	

	square.addClass("square");
	square.css("left",parseInt(Math.random() * 500) + "px" );
	square.css("top",parseInt(Math.random() * 420) + "px");
	square.css("backgroundColor", getRandomColor());

	squareArea.append(square);
}

function getRandomColor(){
	var letters= "0123456789abcdef";
	var result = "#";

	for(var i=0; i<6; i++){
		result += letters.charAt(parseInt(Math.random() * letters.length));
	}

	return result;
}
function animateDiv(element, up, down, speed){
  	var newq = makeNewPosition(element, up, down);
    var oldq = element.offset();
    
    element.animate({ top: newq[0], left: newq[1] }, speed,function(){
      animateDiv(element, newq[2], newq[3], speed);        
    });
}
function makeNewPosition(element, up, down){
  if(parseInt(element.css("top")) >= 420 || parseInt(element.css("top")) <= 25){
  	element.css("backgroundColor", getRandomColor());
  	element.css("border-color", getRandomColor());
  	up = up * -1;
  }
  if(parseInt(element.css("left")) >= 520 || parseInt(element.css("left")) <= 20){
  	element.css("backgroundColor", getRandomColor());
  	element.css("border-color", getRandomColor());
  	down = down * -1;
  }

    // Get viewport dimensions (remove the dimension of the div)
    var h = parseInt(element.css("top")) + (30 * up) + "px";
    var w = parseInt(element.css("left")) + (30 * down);
    
    // var nh = Math.floor(Math.random() * h);
    // var nw = Math.floor(Math.random() * w);
    
    return [h,w,up, down];    
    
}
function calcSpeed() {
    
    var x = Math.random() * 40;
    var y = Math.random() * 40;
    
    var greatest = x > y ? x : y;
    
    var speedModifier = 0.1;

    var speed = Math.ceil(greatest/speedModifier);

    return speed;
}