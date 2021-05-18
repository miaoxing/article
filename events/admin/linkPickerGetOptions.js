import React from 'react';
import Icon from '@mxjs/icons';
import ArticlePicker from './ArticlePicker';

export default [
  {
    value: 'article',
    label: '图文',
    children: [
      {
        value: 'articles/[id]',
        label: <>图文详情 <Icon type="mi-popup"/></>,
        inputLabel: '图文详情',
        picker: ArticlePicker,
        pickerLabel: ArticlePicker.Label,
      },
    ],
  },
];
