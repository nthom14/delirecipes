// App.js
import React, { useState } from 'react';

function App() {
  const [newRecipe, setNewRecipe] = useState({
    title: '',
    category: '',
    ingredients: '',
    instructions: ''
  });

  const handleChange = (e) => {
    const { name, value } = e.target;
    setNewRecipe(prevState => ({ ...prevState, [name]: value }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    fetch('http://localhost/studentfoods-api/add_recipe.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(newRecipe),
    })
      .then(response => response.json())
      .then(data => {
        console.log('Recipe added:', data);
        setNewRecipe({ title: '', category: '', ingredients: '', instructions: '' }); // Καθαρισμός φόρμας
      })
      .catch(error => console.error('Error adding recipe:', error));
  };

  return (
    <div>
      <h1>Προσθήκη Συνταγής</h1>
      <form onSubmit={handleSubmit}>
        <input
          type="text"
          name="title"
          value={newRecipe.title}
          onChange={handleChange}
          placeholder="Τίτλος"
        />
        <input
          type="text"
          name="category"
          value={newRecipe.category}
          onChange={handleChange}
          placeholder="Κατηγορία"
        />
        <input
          type="text"
          name="ingredients"
          value={newRecipe.ingredients}
          onChange={handleChange}
          placeholder="Υλικά"
        />
        <textarea
          name="instructions"
          value={newRecipe.instructions}
          onChange={handleChange}
          placeholder="Οδηγίες"
        />
        <button type="submit">Προσθήκη</button>
      </form>
    </div>
  );
}

export default App;
