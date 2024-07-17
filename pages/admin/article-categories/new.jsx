/**
 * @share [id]/edit
 */
import { CListBtn } from '@mxjs/a-clink';
import { Page, PageActions } from '@mxjs/a-page';
import { Form, FormItem, FormActions } from '@mxjs/a-form';
import { FormItemSort, TreeSelect } from '@miaoxing/admin';
import { Section } from '@mxjs/a-section';

const New = () => {
  return (
    <Page>
      <PageActions>
        <CListBtn/>
      </PageActions>

      <Form>
        <Section>
          <FormItem label="父级分类" name="parentId">
            <TreeSelect
              url="article-categories"
              placeholder="请选择"
              prependData={{
                id: '',
                name: '根分类',
              }}
            />
          </FormItem>
          <FormItem label="名称" name="name" required/>
          <FormItem label="简介" name="description" type="textarea"/>
          <FormItemSort/>
        </Section>
        <FormActions/>
      </Form>
    </Page>
  );
};

export default New;
