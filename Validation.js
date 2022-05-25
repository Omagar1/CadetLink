function processForm(ID){
    console.log(ID);
    HTMLelement = document.getElementById(ID);
    console.log(HTMLelement);  
    // changes the colour of that field  
    HTMLelement.style.borderColor = "red";
    HTMLelement.style.backgroundColor = "pink";
}
  