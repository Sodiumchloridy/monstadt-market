const searchInput = document.getElementById('search-input');

searchInput.addEventListener("focus", handleSuggestion);
searchInput.addEventListener("input", handleSuggestion);

function handleSuggestion() {
    const query = document.getElementById('search-input').value;
    if (query.length > 0) {
        fetch(`/monstadt-market/includes/suggestion.php?search_query=${query}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                let suggestions = document.getElementById('suggestions');
                suggestions.innerHTML = '';

                data.forEach(item => {
                    const suggestionWrappper = document.createElement('a');
                    suggestionWrappper.href = '/monstadt-market/product?id=' + item.prod_id;

                    const suggestionItem = document.createElement('div');
                    suggestionItem.classList.add('suggestion-item');
                    suggestionItem.textContent = item.prod_name;
                    suggestionItem.addEventListener('click', function () {
                        document.getElementById('search-input').value = item.prod_name;
                        document.getElementById('search-form').submit();
                    });
                    suggestionWrappper.appendChild(suggestionItem);
                    suggestions.appendChild(suggestionWrappper);
                });
            });
    } else {
        document.getElementById('suggestions').innerHTML = '';
    }
}
