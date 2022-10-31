//FROM DATABASE: tech tool names
techTools = new Array("aaron", "andrew", "kelvin");
//FROM DATABASE: tech tool descriptions
descs = new Array("a guy", "a guy", "another guy");
//FROM DATABASE: tech tool tags
rawTags = new Array(1112,1113,1314);

const PAGENUM = 1;
filters = new Array(true, true, true, true, true, true, true, true, true);
tags = new Array(rawTags.length);

extractTags();
addAll();
	
function $(id){return document.getElementById(id);}

function extractTags(){
	for(let i=0; i<tags.length; i++){
		input = rawTags[i];
		expandedTag = new Array((input.toString()).length/2);
		for(let j=0; j<expandedTag.length; j++){
			expandedTag[expandedTag.length-j-1]=Math.floor(input%100);
			input/=100;
		}
		tags[i]=expandedTag;
	}
}

function addAll(){
	for(let i=0; i<tags.length; i++){
		for(let j=0; j<tags[i].length; j++){
			if(checkFilter(tags[i][j])){
				addElement(techTools[i],tags[i],descs[i]);
				break;
			}
		}
	}
}

function checkFilter(toCheck){
	return Math.floor(toCheck/10)==PAGENUM && filters[toCheck%10];
}

function addElement(name,expandedTag,descs){
	$("container").innerHTML += "<div id = "+expandedTag+"><h1>"+name+"</h1><p>"+descs+"</p></div>";
}