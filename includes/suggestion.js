const searchInput = document.getElementById('search-input');

searchInput.addEventListener('input', function () {
    const query = document.getElementById('search-input').value;

    if (query.length > 0) { 
        fetch(`/monstadt-market/includes/suggestion.php?search_query=${query}`)
            .then(response => response.json())
            .then(data => {
                let suggestions = document.getElementById('suggestions');
                suggestions.innerHTML = ''; 

                data.forEach(item => {
                    let suggestionItem = document.createElement('div');
                    suggestionItem.classList.add('suggestion-item');
                    suggestionItem.textContent = item;
                    suggestionItem.addEventListener('click', function() {
                        document.getElementById('search-input').value = item;
                        document.getElementById('search-form').submit();
                    });
                    suggestions.appendChild(suggestionItem);
                });
            });
    } else {
        document.getElementById('suggestions').innerHTML = ''; 
    }
});

searchInput.addEventListener("blur", function(){
    document.getElementById('suggestions').innerHTML = "";
});