import React from "react";
import styled from "styled-components";
import logo from "../images/logo.png";
import Input from "./Input";

const Sidebar = () => {
  return (
    <Container>
      <LogoWrapper>
        <img src={logo} alt="" />
        <h3>
          Parent<span> Prof</span>
        </h3>
      </LogoWrapper>
      <Form>
        <h3>Connexion</h3>
        <label>Addresse Mail</label>
        <Input type="email" placeholder="Adresse Mail" />
        <label>Mot de Passe</label>
        <Input type="password" placeholder="Mot de Passe" />
        <div class="form-check">
          <input type="checkbox" class="form-check-input" />
          <label class="form-check-label" for="exampleCheck1">Se souvenir de moi</label>
          <a href="#" class="login__forgot">Mot de passe oublié ? </a>
        </div>
        <button>Connexion</button>
        <br></br>
        <br></br>
        <br></br>
        <br></br>
        <br></br>
        <br></br>
        <br></br>
      </Form>
    </Container>
  );
};


const Form = styled.form`
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: left;

  h3 {
    color: #666666;
    margin-bottom: 2rem;
    text-align: center;
  }
  
  Input {
    margin-left: -40px;
  }
  label {
    margin-rigth: 30px;
  }

  h3 {
    color: #000;
    text-align: center;
  }

  button {
    width: 75%;
    max-width: 350px;
    min-width: 250px;
    height: 40px;
    border: none;
    margin: 1rem 0;
    box-shadow: 0px 14px 9px -15px rgba(0, 0, 0, 0.25);
    border-radius: 8px;
    background-color: #1ABC9C;
    color: #fff;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease-in;

    &:hover {
      transform: translateY(-3px);
    }
  }
`;

const LogoWrapper = styled.div`
  img {
    height: 6rem;
    margin-top: 25px;
  }

  h3 {
    color: #ff8d8d;
    text-align: left;
    font-size: 22px;
    margin-top: 20px;
  }

  span {
    color: #5dc399;
    font-weight: 300;
    font-size: 18px;
  }
`;

const Container = styled.div`
  min-width: 400px;
  backdrop-filter: blur(35px);
  background-color: rgba(255, 255, 255, 0.8);
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-evenly;
  align-items: center;
  padding: 0 2rem;

  @media (max-width: 900px) {
    width: 100vw;
    position: absolute;
    padding: 0;
  }

  .login__forgot {
    display: block;
    width: max-content;
    margin-left: 120px;
    margin-top: 0.5rem;
    font-size: 0.813rem;
    font-weight: 600;
    color: #a49eac;
}

  h4 {
    color: #808080;
    font-weight: bold;
    font-size: 13px;
    margin-top: 2rem;

    span {
      color: #ff8d8d;
      cursor: pointer;
    }
  }
`;

export default Sidebar;
