import {Component} from 'react';
import {View, Text} from '@tarojs/components';
import './show.scss';
import Ret from '@mxjs/m-ret';
import $ from 'miaoxing';

export default class Articles extends Component {
  state = {};

  componentDidMount() {
    $.http({
      url: $.apiUrl('articles/%s', $.req('id')),
      loading: true,
    }).then(({ret}) => {
      if (ret.isErr()) {
        $.ret(ret);
        return;
      }
      this.setState(ret);
    });
  }

  render() {
    const {data = {}} = this.state;

    return (
      <Ret ret={this.state}>
        <Article data={data}/>
      </Ret>
    );
  }
}

const Article = ({data}) => (
  <View className="article-content">
    <View className="article-title">{data.title}</View>

    <View className="article-meta">
      {data.author && <Text className="article-author">
        {data.author}
      </Text>}
      <Text className="article-time">
        {data.updatedAt.substr(0, 10)}
      </Text>
    </View>

    <View className="article-detail" dangerouslySetInnerHTML={{__html: data.detail.content}}/>
  </View>
);
