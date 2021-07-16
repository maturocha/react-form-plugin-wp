import React from 'react'
import styled from 'styled-components';
import ReactLoading from 'react-loading';


const GridStep = styled.div`
  display: grid;
  grid-template-columns: 1fr;
  grid-row-gap: 24px;

  @media (min-width: 560px) {
    grid-template-columns: 1fr 1fr;
    grid-column-gap: 16px;
  }
  

`;

const formContainer = styled.div`
  margin: 16px 0;
`;


const Navigation = styled.div`
padding: 16px 0;
display: block;
text-align: center !important;
margin: 32px 0;
`;

const MessageBox = styled.div`
padding: 12px 0;
margin: 12px 0;
display: block;
width: 100%;
text-align: center;
background-color: #2c8b9630;
`;

const PrevButton = styled.a`
padding-top: 16px;
display: block;
margin: 0 auto;
`;

const NextButton = styled.button`
height: 30px;
line-height: 30px;
font-size: 12px;
padding: 0 16px;
display: block;
margin: 0 auto;

`;

const Loader = styled(ReactLoading)`
margin: 0 auto;
padding: 12px;
`;

export {GridStep, formContainer, Navigation, MessageBox, PrevButton, NextButton, Loader }