import './styles/app.css';
import './bootstrap';
import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router } from 'react-router-dom';
import Default from './components/Default';

ReactDOM.render(<Router><Default /></Router>, document.getElementById('root'));