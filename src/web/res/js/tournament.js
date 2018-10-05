function removeBom(res) {
  if (res.charCodeAt(0) === 0xFEFF) {
    res = res.substr(1);
  }
  return res;
}
function printName(teams, offset) {
    return teams[offset]===undefined?"&nbsp":teams[offset].name;
}
function printTime(teams, offset) {
    return teams[offset]===undefined?"&nbsp":teams[offset].time;
}
function printTier(tier, teams) {
  var result="";
  var noOfTeams=128;
  var tierOffset=0;
  for (var i=0;i<tier-1;i++)
  {
    tierOffset+=noOfTeams>>i;
  }
  result+="<ul class=\"bracket bracket-"+tier+"\">\n";
  if (noOfTeams>>tier == 0) {
        result+="<li class=\"team-item\">"+printName(teams,254)+"</li>\n";
    }
    for (var i=0;i<noOfTeams>>tier;i++) {
        var currentOffset=tierOffset+i*2;
        result+="<li class=\"team-item\">"+printName(teams,currentOffset)+" <time>"+printTime(teams,currentOffset)+"</time> "+printName(teams,currentOffset+1)+"</li>\n";
    }
    result+="</ul>\n";
    return result;
}
function loadDoc() {
  var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var text=removeBom(this.responseText);
        var items=JSON.parse(text);
        var results="";
        for (var i = 1; i <=8; i++) {
          results+=printTier(i, items);
        }
        document.getElementById("tournament").innerHTML = results;
      }
    };
  xhttp.open("GET", "request.php?object=teams", true);
  xhttp.send();
}
loadDoc();
