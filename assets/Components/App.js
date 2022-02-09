import React from "react";
import styled from "styled-components";
import Sidebar from "./Sidebar";
import Main from "./Main";

const App = () => {
  return (
    <Container>
      <Wrapper>
        <Sidebar />
        <Main />
      </Wrapper>
    </Container>
  );
};

const Container = styled.div`
  background: #eefcff;
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
`;
const Wrapper = styled.div`
  background-color: #FAFAFA;
  width: 100%;
  height: 100%;
  display: flex;
`;

export default App;
