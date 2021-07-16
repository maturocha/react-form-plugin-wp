import { Field, useFormikContext } from 'formik'
import React from 'react'
import styled from 'styled-components';
import {TitleH2, IconField, InputGroup} from '../elements/form';
import {GridStep} from '../elements/layout';


function AddressInfo() {
  const { errors, touched, setFieldValue, values } = useFormikContext();
  const postalCodes = require('switzerland-postal-codes');

  const validateNPA = value => {

    let errorMessage;
    let city = postalCodes[values.postalCode];
    if (city) {
      setFieldValue('city', city, false);

    } else {
      setFieldValue('city', '', false)
      errorMessage = window.strings.messages.invalid_npa;
    }

    return errorMessage;

  }

  return (
    <>
      <TitleH2>{window.strings.title.address_facturation}</TitleH2>
      <GridStep>
        <div className="field">
          <label htmlFor="company">{window.strings.fields.company}</label>
          <InputGroup>
            <IconField>
              <span className="fa fa-university"></span>
            </IconField>
            <InputField type="text" name="company" />
          </InputGroup>
        </div>

      <div className="field">
        <label htmlFor="address">{window.strings.fields.address}* </label>
        <InputGroup>
            <IconField>
              <span className="fa fa-home"></span>
            </IconField>
            <InputField type="text" name="address" />
        </InputGroup>
        {touched.address && errors.address &&
          <small style={{ color: 'red' }}>
            {touched.address && errors.address}
          </small>
        }
      </div>

      <div className="field">
        <label htmlFor="postalCode">{window.strings.fields.postal_code}* </label>
        <InputGroup>
            <IconField>
              <span className="fa fa-envelope"></span>
            </IconField>
            <InputField type="number" validate={validateNPA}  name="postalCode" />
        </InputGroup>
        {touched.postalCode && errors.postalCode &&
          <small style={{ color: 'red' }}>
            {touched.postalCode && errors.postalCode}
          </small>
        }
      </div>

      <div className="field">
        <label htmlFor="city">{window.strings.fields.city}* </label>
        <InputGroup>
            <IconField>
              <span className="fa fa-map-signs"></span>
            </IconField>
            <InputField type="text" name="city" />
        </InputGroup>
        {errors.city &&
          <small style={{ color: 'red' }}>
            {errors.city}
          </small>
        }
      </div>
    </GridStep>
  </>
  )
}

export default AddressInfo;

export const InputField = styled(Field)`
border: 3px solid #9d9fa1;
color: #34495e;
height: 40px;
border-top-right-radius: 6px;
border-bottom-right-radius: 6px;
-webkit-box-shadow: none;
box-shadow: none; 
  -webkit-appearance: none; 
  -webkit-transform: translateZ(0px);
  -ms-transform: translateZ(0px);
  font-size: 16px;
  width: 230px;
  padding-left: 6px;
  -webkit-font-smoothing: antialiased;
  line-height: unset;
  &:-internal-autofill-selected {
    -webkit-box-shadow:  rgba(52,113,130,0.3) 0px 1px;
    -webkit-transition: unset;
    transition: unset;
    background: none;
    background-color: none !important;
  } 
`;
