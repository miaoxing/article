import {
  Table,
  TableProvider,
  CTableDeleteLink,
  useTable,
  TableActions,
  useExpand,
  TableExpandIcon
} from '@mxjs/a-table';
import { CEditLink, CNewBtn } from '@mxjs/a-clink';
import { Page, PageActions } from '@mxjs/a-page';
import { SearchForm, SearchItem } from '@mxjs/a-form';

const removeEmptyChildren = (data) => {
  return data.map(item => {
    if (item.children) {
      if (0 === item.children.length) {
        delete item.children;
      } else {
        item.children = removeEmptyChildren(item.children);
      }
    }
    return item;
  });
};

const Index = () => {
  const [table] = useTable();
  const { expanded, onExpand, expandedRowKeys, setData, onExpandAll } = useExpand();

  return (
    <Page>
      <TableProvider>
        <PageActions>
          <CNewBtn/>
        </PageActions>

        <SearchForm>
          <SearchItem label="名称" name={['search', 'name:ct']}/>
        </SearchForm>

        <Table
          tableApi={table}
          expandedRowKeys={expandedRowKeys}
          onExpand={onExpand}
          postData={(data) => {
            data = removeEmptyChildren(data);
            setData(data);
            return data;
          }}
          pagination={{
            pageSize: 500,
          }}
          columns={[
            {
              title: <>
                <TableExpandIcon expanded={expanded} onExpand={onExpandAll}/>
                名称
              </>,
              dataIndex: 'name',
            },
            {
              title: '简介',
              dataIndex: 'description',
            },
            {
              title: '顺序',
              dataIndex: 'sort',
              sorter: true,
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
