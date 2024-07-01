import { Table, TableProvider, CTableDeleteLink, useTable, TableActions } from '@mxjs/a-table';
import {CEditLink, CNewBtn} from '@mxjs/a-clink';
import {Page, PageActions} from '@mxjs/a-page';
import {SearchForm, SearchItem} from '@mxjs/a-form';
import {Tag} from 'antd';
import {TreeSelect} from '@miaoxing/admin';

const Index = () => {
  const [table] = useTable();

  return (
    <Page>
      <TableProvider>
        <PageActions>
          <CNewBtn/>
        </PageActions>

        <SearchForm>
          <SearchItem label="分类" name={['search', 'categoryId']}>
            <TreeSelect
              url="article-categories"
              placeholder="全部"
              prependData={{
                id: '0',
                name: '未分类',
              }}
            />
          </SearchItem>

          <SearchItem label="标题" name={['search', 'title:ct']}/>
        </SearchForm>

        <Table
          tableApi={table}
          columns={[
            {
              title: '分类',
              dataIndex: ['category', 'name'],
            },
            {
              title: '标题',
              dataIndex: 'title',
              render: (value, row) => {
                return (
                  <>
                    {value}
                    {' '}
                    {Object.keys(row.redirectLink).length !== 0 && <Tag>跳转</Tag>}
                  </>
                );
              },
            },
            {
              title: '作者',
              dataIndex: 'author',
            },
            {
              title: '顺序',
              dataIndex: 'sort',
              sorter: true,
            },
            {
              title: '修改时间',
              dataIndex: 'updatedAt',
            },
            {
              title: '操作',
              dataIndex: 'id',
              render: (id) => (
                <TableActions>
                  <CEditLink id={id}/>
                  <CTableDeleteLink id={id}/>
                </TableActions>
              ),
            },
          ]}
        />
      </TableProvider>
    </Page>
  );
};

export default Index;
