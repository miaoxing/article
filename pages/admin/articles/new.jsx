/**
 * @share [id]/edit
 */
import {CListBtn} from '@mxjs/a-clink';
import {Page, PageActions} from '@mxjs/a-page';
import {Form, FormItem, FormAction} from '@mxjs/a-form';
import {FormUeditor} from '@mxjs/a-ueditor';
import LinkPicker from '@miaoxing/link-to/components/LinkPicker';
import {Input} from 'antd';
import {FormItemSort, Upload, TreeSelect} from '@miaoxing/admin';

const New = () => {
  return (
    <Page>
      <PageActions>
        <CListBtn/>
      </PageActions>

      <Form
        afterLoad={({ret}) => {
          // 未分类提示"请选择"
          if (!ret.data.categoryId) {
            delete ret.data.categoryId;
          }
        }}
      >
        <FormItem label="分类" name="categoryId">
          <TreeSelect
            url="article-categories"
            placeholder="请选择"
            prependData={{
              id: '',
              name: '未分类',
            }}
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
