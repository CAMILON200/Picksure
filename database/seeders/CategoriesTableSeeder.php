<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Category;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        //Data Type
        $dataType = $this->dataType('name', 'categories');
        if (!$dataType->exists) {
            $dataType->fill([
                'slug'                  => 'categories',
                'display_name_singular' => __('voyager::seeders.data_types.category.singular'),
                'display_name_plural'   => __('voyager::seeders.data_types.category.plural'),
                'icon'                  => 'voyager-categories',
                'model_name'            => 'TCG\\Voyager\\Models\\Category',
                'controller'            => '',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }
        //Data Rows
        $categoryDataType = DataType::where('slug', 'categories')->firstOrFail();
        $dataRow = $this->dataRow($categoryDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => __('voyager::seeders.data_rows.id'),
                'required'     => 1,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($categoryDataType, 'parent_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'select_dropdown',
                'display_name' => __('voyager::seeders.data_rows.parent'),
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'default' => '',
                    'null'    => '',
                    'options' => [
                        '' => '-- None --',
                    ],
                    'relationship' => [
                        'key'   => 'id',
                        'label' => 'name',
                    ],
                ],
                'order' => 2,
            ])->save();
        }

        $dataRow = $this->dataRow($categoryDataType, 'order');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => __('voyager::seeders.data_rows.order'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'default' => 1,
                ],
                'order' => 3,
            ])->save();
        }

        $dataRow = $this->dataRow($categoryDataType, 'name');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => __('voyager::seeders.data_rows.name'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 4,
            ])->save();
        }

        $dataRow = $this->dataRow($categoryDataType, 'slug');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => __('voyager::seeders.data_rows.slug'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'slugify' => [
                        'origin' => 'name',
                    ],
                ],
                'order' => 5,
            ])->save();
        }

        $dataRow = $this->dataRow($categoryDataType, 'img_url');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => __('voyager::seeders.data_rows.img_url'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => 6,
            ])->save();
        }

        $dataRow = $this->dataRow($categoryDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'timestamp',
                'display_name' => __('voyager::seeders.data_rows.created_at'),
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => 7,
            ])->save();
        }

        $dataRow = $this->dataRow($categoryDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'timestamp',
                'display_name' => __('voyager::seeders.data_rows.updated_at'),
                'required'     => 0,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => 8,
            ])->save();
        }

        //Menu Item
        $menu = Menu::where('name', 'admin')->firstOrFail();
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => __('voyager::seeders.menu_items.categories'),
            'url'     => '',
            'route'   => 'voyager.categories.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-categories',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 9,
            ])->save();
        }

        //Permissions
        Permission::generateFor('categories');

        //Content
        $category = Category::firstOrNew([
            'slug' => 'bathroom',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Bathroom',
                'order' => 1,
                'img_url' => 'categories/Banios-Bathroom.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'bbq',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'BBQ',
                'order' => 2,
                'img_url' => 'categories/BBQ-BBQ.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'cottages',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Cottages',
                'order' => 3,
                'img_url' => 'categories/Cabañas-Cottages.jpg'
            ])->save();
        }

        $category = Category::firstOrNew([
            'slug' => 'beach-houses',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Beach Houses',
                'order' => 4,
                'img_url' => 'categories/Casas-de-playa–Beach-houses.jpg'
            ])->save();
        }

        $category = Category::firstOrNew([
            'slug' => 'houses',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Houses',
                'order' => 5,
                'img_url' => 'categories/Casas-Houses.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'cgi',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'CGI',
                'order' => 6,
                'img_url' => 'categories/CGI–CGI.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'fireplace',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Fireplace',
                'order' => 7,
                'img_url' => 'categories/Chimeneas-Fireplace.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'kitchen',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Kitchen',
                'order' => 8,
                'img_url' => 'categories/Cocinas-Kitchen.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'dining-room',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Dining Room',
                'order' => 9,
                'img_url' => 'categories/Comedor-Dining-room.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'buildings',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Buildings',
                'order' => 10,
                'img_url' => 'categories/Edificios-Buildings.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'appliances',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Appliances',
                'order' => 11,
                'img_url' => 'categories/Electodomésticos-Appliances.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'stairs',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Stairs',
                'order' => 12,
                'img_url' => 'categories/Escaleras-Stairs.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'faucets',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Faucets',
                'order' => 13,
                'img_url' => 'categories/Grifería-Faucets.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'gym',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'GYM',
                'order' => 14,
                'img_url' => 'categories/GYM–GYM.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'bedroom',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Bedroom',
                'order' => 15,
                'img_url' => 'categories/Habitacion-Bedroom.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'kids-room',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Kids Room',
                'order' => 16,
                'img_url' => 'categories/Habitacion-Ninios-Kids-room.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'hotels',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Hotels',
                'order' => 17,
                'img_url' => 'categories/Hotel-Hotels.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'lighting',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Lighting',
                'order' => 18,
                'img_url' => 'categories/Iluminación–Lighting.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'interior-design',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Interior Design',
                'order' => 19,
                'img_url' => 'categories/Interiorismo-Interior-design.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'laund-room',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Laundry Room',
                'order' => 20,
                'img_url' => 'categories/Lavanderia-Laundry-room.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'materials',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Materials',
                'order' => 21,
                'img_url' => 'categories/Materiales-Materials.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'outdoor-furniture',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Outdoor Furniture',
                'order' => 22,
                'img_url' => 'categories/Muebles-exterior-Outdoor-Furniture.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'furniture',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Furniture',
                'order' => 23,
                'img_url' => 'categories/Muebles-Furniture.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'pools',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Pools',
                'order' => 24,
                'img_url' => 'categories/Piscinas-Pools.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'game-room',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Game Room',
                'order' => 25,
                'img_url' => 'categories/Playromm–Gameroom.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'restaurants',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Restaurants',
                'order' => 26,
                'img_url' => 'categories/Restaurantes–Restaurants.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'livingroom',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Livingroom',
                'order' => 27,
                'img_url' => 'categories/Sala-Livingroom.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'hometheater',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Hometheater',
                'order' => 28,
                'img_url' => 'categories/Teatroencasa-Hometheater.jpg'
            ])->save();
        }
        
        $category = Category::firstOrNew([
            'slug' => 'dressing-room',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name' => 'Dressingroom',
                'order' => 29,
                'img_url' => 'categories/Vestier-Dressingroom.jpg'
            ])->save();
        }
        
        
    }

    /**
     * [dataRow description].
     *
     * @param [type] $type  [description]
     * @param [type] $field [description]
     *
     * @return [type] [description]
     */
    protected function dataRow($type, $field)
    {
        return DataRow::firstOrNew([
            'data_type_id' => $type->id,
            'field'        => $field,
        ]);
    }

    /**
     * [dataType description].
     *
     * @param [type] $field [description]
     * @param [type] $for   [description]
     *
     * @return [type] [description]
     */
    protected function dataType($field, $for)
    {
        return DataType::firstOrNew([$field => $for]);
    }
}
