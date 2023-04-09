<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Blog\Models\Category;
use Botble\Blog\Models\Tag;
use Botble\Ecommerce\Models\Brand;
use Botble\Ecommerce\Models\ProductCategory;
use Botble\Ecommerce\Models\ProductTag;
use Botble\Menu\Models\Menu as MenuModel;
use Botble\Menu\Models\MenuLocation;
use Botble\Menu\Models\MenuNode;
use Botble\Page\Models\Page;
use Illuminate\Support\Arr;
use Menu;

class MenuSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                'name'     => 'Main menu',
                'slug'     => 'main-menu',
                'location' => 'main-menu',
                'items'    => [
                    [
                        'title' => 'Trang chủ',
                        'url'   => '/',
                    ],
                    [
                        'title' => 'Tất cả sản phẩm',
                        'url'   => '/products',
                    ],
                    [
                        'title'    => 'Sản Phẩm',
                        'url'      => '#',
                        'children' => [
                            [
                                'title'          => 'Danh mục sản phẩm',
                                'reference_id'   => 1,
                                'reference_type' => ProductCategory::class,
                            ],
                            [
                                'title'          => 'Thương hiệu',
                                'reference_id'   => 1,
                                'reference_type' => Brand::class,
                            ],
                            [
                                'title'          => 'Nổi bật ',//Product Tag
                                'reference_id'   => 1,
                                'reference_type' => ProductTag::class,
                            ],
                            [
                                'title' => 'Sản phẩm đơn',
                                'url'   => 'products/beat-headphone',
                            ],
                        ],
                    ],
                    [
                        'title'          => 'Tin tức',
                        'reference_id'   => 3,
                        'reference_type' => Page::class,
                        'children'       => [
                            [
                                'title'          => 'Blog Left Sidebar',
                                'reference_id'   => 3,
                                'reference_type' => Page::class,
                            ],
                            [
                                'title'          => 'Chi tiết bài viết',
                                'reference_id'   => 1,
                                'reference_type' => Category::class,
                            ],
                            [
                                'title'          => 'Blog Tag',
                                'reference_id'   => 1,
                                'reference_type' => Tag::class,
                            ],
                            [
                                'title' => 'Blog Single',
                                'url'   => 'news/4-expert-tips-on-how-to-choose-the-right-mens-wallet',
                            ],
                        ],
                    ],
                    [
                        'title'          => 'Liên hệ chúng tôi',//contact
                        'reference_id'   => 2,
                        'reference_type' => Page::class,
                    ],
                ],
            ],
            [
                'name'  => 'Useful Links',
                'slug'  => 'useful-links',
                'items' => [
                    [
                        'title'          => 'Về chúng tôi',//About Us
                        'reference_id'   => 4,
                        'reference_type' => Page::class,
                    ],
                    [
                        'title'          => 'Câu hỏi thường gặp',//FAQ
                        'reference_id'   => 5,
                        'reference_type' => Page::class,
                    ],
                    [
                        'title'          => 'Vị trí',
                        'reference_id'   => 6,
                        'reference_type' => Page::class,
                    ],
                    [
                        'title'          => 'Affiliates',
                        'reference_id'   => 7,
                        'reference_type' => Page::class,
                    ],
                    [
                        'title'          => 'Liên hệ',//Contact
                        'reference_id'   => 2,
                        'reference_type' => Page::class,
                    ],
                ],
            ],
            [
                'name'  => 'Categories',
                'slug'  => 'categories',
                'items' => [
                    [
                        'title'          => 'Áo Thun',
                        'reference_id'   => 1,
                        'reference_type' => ProductCategory::class,
                    ],
                    [
                        'title'          => 'Áo Tay Dài',
                        'reference_id'   => 2,
                        'reference_type' => ProductCategory::class,
                    ],
                    [
                        'title'          => 'Quần',
                        'reference_id'   => 3,
                        'reference_type' => ProductCategory::class,
                    ],
                    [
                        'title'          => 'Nón',
                        'reference_id'   => 4,
                        'reference_type' => ProductCategory::class,
                    ],
                    [
                        'title'          => 'Phụ kiện',
                        'reference_id'   => 5,
                        'reference_type' => ProductCategory::class,
                    ],
                ],
            ],
            [
                'name'  => 'My Account',
                'slug'  => 'my-account',
                'items' => [
                    [
                        'title' => 'Thông tin của tôi',
                        'url'   => '/customer/overview',
                    ],
                    [
                        'title' => 'Danh sách yêu thích',
                        'url'   => '/wishlist',
                    ],
                    [
                        'title' => 'Orders',
                        'url'   => 'customer/orders',
                    ],
                    [
                        'title' => 'Order tracking',
                        'url'   => '/orders/tracking',
                    ],
                ],
            ],
        ];

        MenuModel::truncate();
        MenuLocation::truncate();
        MenuNode::truncate();

        foreach ($menus as $index => $item) {
            $menu = MenuModel::create(Arr::except($item, ['items', 'location']));

            if (isset($item['location'])) {
                MenuLocation::create([
                    'menu_id'  => $menu->id,
                    'location' => $item['location'],
                ]);
            }

            foreach ($item['items'] as $menuNode) {
                $this->createMenuNode($index, $menuNode);
            }

        }

        Menu::clearCacheMenuItems();
    }

    /**
     * @param int $index
     * @param array $menuNode
     * @param int $parentId
     */
    protected function createMenuNode(int $index, array $menuNode, int $parentId = 0): void
    {
        $menuNode['menu_id'] = $index + 1;
        $menuNode['parent_id'] = $parentId;

        if (Arr::has($menuNode, 'children')) {
            $children = $menuNode['children'];
            $menuNode['has_child'] = true;

            unset($menuNode['children']);
        } else {
            $children = [];
            $menuNode['has_child'] = false;
        }

        $createdNode = MenuNode::create($menuNode);

        if ($children) {
            foreach ($children as $child) {
                $this->createMenuNode($index, $child, $createdNode->id);
            }
        }
    }
}
