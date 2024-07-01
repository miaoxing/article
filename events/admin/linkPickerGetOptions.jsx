import Icon from '@mxjs/icons';
import ArticlePicker from './ArticlePicker';
import CategoryPicker from './CategoryPicker';

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
      {
        value: 'article-categories/[id]',
        label: <>图文分类 <Icon type="mi-popup"/></>,
        inputLabel: '图文分类',
        picker: CategoryPicker,
        pickerLabel: CategoryPicker.Label,
      },
    ],
  },
];
