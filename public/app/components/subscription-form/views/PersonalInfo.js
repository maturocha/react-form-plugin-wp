import { useFormikContext, Field } from 'formik'
import React from 'react'
import styled from 'styled-components';
import {FormGroup, IconField, TitleH2, InputGroup} from '../elements/form';
import {GridStep} from '../elements/layout';
import PhoneInput from 'react-phone-input-2'

function PersonalInfo( ) {
  const { errors, touched, setFieldValue, values } = useFormikContext()

  return (
    <>
      <TitleH2>{window.strings.title.my_account}</TitleH2>
      <GridStep>
      <FormGroup>
        <label htmlFor="firstname">{window.strings.fields.firstname}* </label>
        <InputGroup>
          <IconField>
            <span className="fa fa-user"></span>
          </IconField>
          <InputField type="text" name="firstname" />
        </InputGroup>
          <small style={{ color: 'red' }}>
            {touched.firstname && errors.firstname}
          </small>
      </FormGroup>

      <FormGroup>
        <label htmlFor="lastname">{window.strings.fields.lastname}* </label>
        <InputGroup>
          <IconField>
            <span className="fa fa-user"></span>
          </IconField>
          <InputField type="text" name="lastname" />
        </InputGroup>
          <small style={{ color: 'red' }}>
            {touched.lastname && errors.lastname}
          </small>
      </FormGroup>

      <FormGroup>
        <label htmlFor="phone">{window.strings.fields.telephone}* </label>
        <InputGroup>
          <IconField>
            <span className="fa fa-phone"></span>
          </IconField>
          <PhoneInput
            country={'ch'}
            onlyCountries={['fr','ch']}
            value={values.phone}
            onChange={phone => setFieldValue('phone', phone, false)}
          />
        </InputGroup>
        {touched.phone && errors.phone &&
          <small style={{ color: 'red' }}>
            {touched.phone && errors.phone}
          </small>
        }
      </FormGroup>

      <FormGroup>
        <label htmlFor="email">{window.strings.fields.email}* </label>
        <InputGroup>
          <IconField>
            <span className="fa fa-envelope"></span>
          </IconField>
          <InputField  type="email" name="email" />
        </InputGroup>
        {touched.email && errors.email &&
          <small style={{ color: 'red' }}>
            {touched.email && errors.email}
          </small>
        }
      </FormGroup>

      <FormGroup>
        <label htmlFor="password">{window.strings.fields.password}* </label>
        <InputGroup>
          <IconField>
            <span className="fa fa-lock"></span>
          </IconField>
          <InputField type="password" autoComplete="one-time-code" name="password" />
        </InputGroup>
        {touched.password && errors.password &&
          <small style={{ color: 'red' }}>
            {touched.password && errors.password}
          </small>
        }
      </FormGroup>

      <FormGroup>
        <label htmlFor="passwordConfirmation">{window.strings.fields.password_confirmation}* </label>
        <InputGroup>
          <IconField>
            <span className="fa fa-lock"></span>
          </IconField>
          <InputField type="password" autoComplete="one-time-code" name="passwordConfirmation" />
        </InputGroup>
        {touched.passwordConfirmation && errors.passwordConfirmation &&
          <small style={{ color: 'red' }}>
            {touched.passwordConfirmation && errors.passwordConfirmation}
          </small>
        }
      </FormGroup>
    </GridStep>
    </>
  )
}

export default PersonalInfo;

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

