/**
 * @share [id]/edit
 */
import { useEffect, useState } from 'react';
import {CListBtn} from '@mxjs/a-clink';
import {Page, PageActions} from '@mxjs/a-page';
import {Form, FormItem, FormAction} from '@mxjs/a-form';
import $ from 'miaoxing';
import {FormUeditor} from '@mxjs/ueditor';
import LinkPicker from '@miaoxing/link-to/components/LinkPicker';
import api from '@mxjs/api';
import {Input, TreeSelect} from 'antd';
import {FormItemSort, Upload} from '@miaoxing/admin';

const New = () => {
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

  return (
    <Page>
      <PageActions>
        <CListBtn/>
      </PageActions>

      <Form
        afterLoad={({ret}) => {
          // 避免分类显示 "0"
          if (!ret.data.id) {
            delete ret.data.categoryId;
          }
        }}
      >
        <FormItem label="分类" name="categoryId" required>
          <TreeSelect
            showSearch
            showArrow
            allowClear
            treeDefaultExpandAll
            placeholder="请选择"
            treeData={categories}
          />
        </FormItem>

        <FormItem label="标题" name="title" required/>

        <FormItem label="作者" name="author"/>

        <FormItem label="封面" name="cover" extra="支持.jpg .jpeg .bmp .gif .png格式照片">
          <Upload max={1}/>
        </FormItem>

        <FormItem label="摘要" name="intro" type="textarea">
          <Input.TextArea maxLength={255} showCount/>
        </FormItem>

        <FormUeditor label="正文" name={['detail', 'content']}/>

        <FormItem label="原文链接" name="sourceLink">
          <LinkPicker/>
        </FormItem>

        <FormItem label="跳转地址" name="redirectLink">
          <LinkPicker/>
        </FormItem>

        <FormItemSort/>

        <FormItem name="id" type="hidden"/>

        <FormAction/>
      </Form>
    </Page>
  );
};

export default New;
