import { useState, useEffect } from 'react';
import {Card, Radio, Select, TreeSelect, InputNumber} from 'antd';
import PropTypes from 'prop-types';
import {FormItem, useForm} from '@mxjs/a-form';
import $ from 'miaoxing';
import api from '@mxjs/api';
import ConfigArticlePicker from './ConfigArticlePicker';

const ArticleConfig = ({propName}) => {
  // 加载图文分类
  const [categories, setCategories] = useState([]);
  useEffect(() => {
    api.getMax('article-categories', {loading: true}).then(({ret}) => {
      if (ret.isSuc()) {
        setCategories(ret.data.map(category => ({
          value: category.id,
          title: category.name,
          children: category.children.map(subCategory => ({
            value: subCategory.id,
            title: subCategory.name,
          })),
        })));
      } else {
        $.ret(ret);
      }
    });
  }, []);

  const form = useForm();
  const [source, setSource] = useState(form.getFieldValue(['components'].concat(propName(['source']))));

  return (
    <Card title="图文列表">
      <FormItem label="数据来源" name={propName(['source'])}>
        <Radio.Group onChange={e => {
          setSource(e.target.value);
        }}>
          <Radio value="all">全部</Radio>
          <Radio value="category">指定分类</Radio>
          <Radio value="article">指定图文</Radio>
        </Radio.Group>
      </FormItem>

      {source === 'category' && <FormItem label="选择分类" name={propName(['categoryIds'])}>
        <TreeSelect
          showSearch
          showArrow
          allowClear
          multiple
          treeDefaultExpandAll
          placeholder="请选择"
          treeData={categories}
        />
      </FormItem>}

      {source === 'article' && <FormItem label="选择图文" name={propName(['articleIds'])}>
        <ConfigArticlePicker/>
      </FormItem>}

      {source !== 'article' && <FormItem label="数量" name={propName(['num'])} extra="最多展示 20 篇">
        <InputNumber min={1} max={20} style={{width: '100%'}}/>
      </FormItem>}

      <FormItem label="样式" name={propName(['tpl'])}>
        <Select>
          <Select.Option value={1}>上面图片，下面标题</Select.Option>
          <Select.Option value={2}>只显示标题</Select.Option>
          <Select.Option value={3}>左边图片，右边标题</Select.Option>
          <Select.Option value={4}>左边标题，右边图片</Select.Option>
        </Select>
      </FormItem>
    </Card>
  );
};

ArticleConfig.propTypes = {
  propName: PropTypes.func,
};

export default ArticleConfig;
