// Get the input field and the list of items to search through
// These two lines need to be adjusted to fit the node js format 
const input = document.getElementById("searchInput");
const items = document.querySelectorAll(".list-item");

function Search(input){
    //user's search query
  const target = input.value.toLowerCase();

  // Filter through the list of items and display only the ones that match the search query
  items.forEach(item => {
    const itemText = item.textContent.toLowerCase();
    if (itemText.includes(target)) {
      item.style.display = "block";
    } 
    else {
      item.style.display = "none";
    }
  });
}

  
