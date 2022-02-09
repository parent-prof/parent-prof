import React, {Component} from 'react';
import {Link} from 'react-router-dom';
import home from '../images/icons8-accueil-48.png';

class Default extends Component {

    render() {
        return (
            <nav id="sidebar" className={"p-1"}>
                <div className="sidebar-header">
                    <h3>P~P</h3>
                </div>

                <ul className="list-unstyled components">
                    <li className="active d-flex">
                        <img src={home} alt="" width={30} height={30}/>
                        <a href="#menu">Accueil</a>
                    </li>
                    <li>
                        <a href="#menu">Ilustración</a>


                    </li>
                    <li>
                        <a href="#menu">Interacción</a>
                    </li>
                    <li>
                        <a href="#">Blog</a>
                    </li>
                    <li>
                        <a href="#">Acerca</a>
                    </li>
                    <li>
                        <a href="#">contacto</a>
                    </li>


                </ul>


            </nav>
        )
    }
}

export default Default;