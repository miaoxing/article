/**
 * @share [id]/edit
 */
import { useEffect, useState } from 'react';
import {CListBtn} from '@mxjs/a-clink';
import {Page, PageActions} from '@mxjs/a-page';
import {Form, FormItem, FormAction, Select} from '@mxjs/a-form';
import api from '@mxjs/api';

const New = () => {
  const [parents, setParents] = useState([]);

  useEffect(() => {
    api.getMaxCurColl({loading: true}).then(({ret}) => {
      setParents(ret.data);
    });
  }, []);

  return (
    <Page>
      <PageActions>
        <CListBtn/>
      </PageActions>

      <Form>
        <FormItem label="父级分类" name="parentId" required>
          <Select options={parents} labelKey="name" valueKey="id" firstLabel="根分类"/>
        </FormItem>
        <FormItem label="名称" name="name" required/>
        <FormItem label="简介" name="description" type="textarea"/>
        <FormItem label="顺序" name="sort" type="number" extra="大的显示在前面，按从大到小排列。"/>
        <FormItem name="id" type="hidden"/>
        <FormAction/>
      </Form>
    </Page>
  );
};

export default New;
