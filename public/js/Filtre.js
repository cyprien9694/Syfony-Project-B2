document.addEventListener('DOMContentLoaded', () => {
			const filter = document.getElementById('category-filter');
			const cards = document.querySelectorAll('.star-card');

			filter.addEventListener('change', () => {
				const selected = filter.value.toLowerCase().trim();

				cards.forEach(card => {
					const category = card.dataset.category.toLowerCase().trim();
					if (selected === 'all' || category === selected) {
						card.style.display = '';
					} else {
						card.style.display = 'none';
					}
				});
			});
		});