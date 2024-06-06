document.addEventListener('DOMContentLoaded', function() {
  const questionTitles = document.querySelectorAll('.question-title');

  questionTitles.forEach(function(title) {
      title.addEventListener('click', function(event) {
          // Affiche des informations de débogage dans la console
          console.log('Titre cliqué:', this);
          const answer = this.parentNode.querySelector('.answer');
          console.log('Élément réponse:', answer);

          // Basculer la classe 'hidden' pour montrer ou cacher la réponse
          if (answer.style.display === 'none' || answer.classList.contains('hidden')) {
              answer.style.display = 'block';
              answer.classList.remove('hidden');
              this.querySelector('.arrow').classList.replace('bxs-chevron-down', 'bxs-chevron-up');
          } else {
              answer.style.display = 'none';
              answer.classList.add('hidden');
              this.querySelector('.arrow').classList.replace('bxs-chevron-up', 'bxs-chevron-down');
          }
      });
  });
});
