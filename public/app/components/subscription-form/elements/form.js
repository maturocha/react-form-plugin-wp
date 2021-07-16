
import React from 'react'
import styled from 'styled-components';

const FormGroup = styled.div`
  text-align: center;
`;

const IconField = styled.span`
  font-size: 25px !important;
  background-color: #9d9fa1;
  color: #ffffff;
  padding: 8px;
  font-size: 20px;
  padding: 8px;
  width: 42px;
  text-align: center;
  border: 1px solid #9d9fa1;
  border-top-left-radius: 6px;
  border-bottom-left-radius: 6px;
`;
const InputGroup = styled.div`
  display: flex;
  
`;

 const TitleH2 = styled.h2`
  padding: 12px 0;
  text-align: center;
  margin-bottom: 44px;
  color: #9d9fa1;
`;

 const TitleH4 = styled.h4`
  color: #ff9f1f;
  padding: 8px 0;
  text-align: center;
`;

 const TitleH6 = styled.h6`
  color: #fea03d;
  padding: 8px 0;
  text-align: center;
  font-size: 26px;
`;

const TitleStrike = styled.span`
  color: #6b6a6a;
  -webkit-text-decoration: line-through;
  text-decoration: line-through;
  text-align: center;
  display: block;
  padding: 4px 0;
`;

const Paragraph = styled.p`
  text-align: center;
  font-size: 12px;
  font-weight: 500;
`;

const SwitchContainer = styled.div`
text-align: center;
padding: 8px;
`;

const Img = styled.img`
width: 120px;
margin: 12px auto;
display: block;
`;

 export {TitleH2, TitleH4, TitleH6, TitleStrike, Paragraph, SwitchContainer, IconField, InputGroup, FormGroup, Img}