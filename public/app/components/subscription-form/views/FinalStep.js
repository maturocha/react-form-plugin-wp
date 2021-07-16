import { useFormikWizard } from 'formik-wizard'
import {useFormikContext, Field} from 'formik'
import React from 'react';
import {TitleH2, TitleStrike, TitleH6, Paragraph, Img} from '../elements/form';

function FinalStep() {
  const { values, errors } = useFormikContext();

  return (
    <>
      <TitleH2>{window.strings.title.my_subscription}</TitleH2>
      <div id="price" dangerouslySetInnerHTML={{__html: values.price_html}}></div>
      <Paragraph>{window.strings.messages.without_charges}</Paragraph>
    </>
  )
}

export default FinalStep