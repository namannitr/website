
import React, { Component } from 'react';
import logo from './favicon1.ico';
import './App.css';

class App extends Component {
  render() {
    return (
      <div className="App">
        <header className="App-header">
          <img src={logo} className="App-logo" alt="logo" />
          <h1 className="App-title">Naman Application</h1>
        </header>
        <p className="App-intro">
          Just getting started
        </p>
      </div>
    );
  }
}

export default App;
