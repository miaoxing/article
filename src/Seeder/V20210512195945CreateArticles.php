<?php

namespace Miaoxing\Article\Seeder;

use Faker\Factory;
use Miaoxing\Article\Service\ArticleCategoryModel;
use Miaoxing\Article\Service\ArticleModel;
use Miaoxing\Plugin\Seeder\BaseSeeder;

class V20210512195945CreateArticles extends BaseSeeder
{
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $faker = Factory::create('zh_CN');

        $categoryIds = [];
        foreach (range(1, 10) as $i) {
            $category = $this->createCategory($faker);
            foreach (range(1, 2) as $j) {
                $subCategory = $this->createCategory($faker, [
                    'parentId' => $category->id,
                    'level' => 2,
                ]);
                $categoryIds[] = $subCategory->id;
            }
        }

        foreach (range(1, 30) as $i) {
            $article = ArticleModel::saveAttributes([
                'categoryId' => $faker->randomElement($categoryIds),
                'title' => $faker->words(3, true),
                'author' => $faker->optional(0.8)->name,
            ]);
            $article->detail()->saveRelation([
                'content' => $faker->realText(),
            ]);
        }
    }

    protected function createCategory($faker, $attributes = [])
    {
        return ArticleCategoryModel::saveAttributes($attributes + [
                'name' => $faker->words(2, true),
                'description' => $faker->sentence,
            ]);
    }
}
