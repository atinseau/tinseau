import React, {useEffect, useState} from 'react'
import {Listbox} from "@headlessui/react";

import WooCommerceRestApi from "@woocommerce/woocommerce-rest-api";
import "./catalog.scss"
import {ChevronDownIcon} from '@heroicons/react/solid'

const query = new URLSearchParams(window.location.search);
const api = new WooCommerceRestApi({
    url: "http://localhost",
    consumerKey: "ck_635975220531695c871917115b1185eb153f6b00",
    consumerSecret: "cs_69788f85b20ef9b5494938e8bc953718bf1ee5bc",
    version: "wc/v3"
});

const orderAttributs = [
    {
      value: "default",
      label: "Trier par défaut"
    },
    {
        value: "date",
        label: "Trier par date"
    },
    {
        value: "price",
        label: "Trier par prix"
    },
    {
        value: "popularity",
        label: "Trier par popularité"
    },
    {
        value: "title",
        label: "Trier par titre"
    },
    {
        value: "rating",
        label: "Trier par note"
    }
]

api.axiosConfig.headers = {}

const CategoryList = ({setCategory, selectedCategory, setCategories, categories, root = false, indent}) => {
    return (<div className={"catalog__categories__list " + (!root ? "child" : "")} style={{
        marginLeft: `${indent}px`
    }}>
        {root && <div className="catalog__category__container">
            <div onClick={() => setCategory(null)}
                 className={"catalog__category " + (selectedCategory == null ? "active" : "")}>Toutes
            </div>
        </div>}
        {categories.map((category, id) => <div className="catalog__category__container" key={id}>
            <div
                className={"catalog__category " + (selectedCategory == category.id ? "active" : "")}
                key={category.id}
            >
                <div className="hitbox__pick" onClick={() => setCategory(category)}>
                    <p>{category.name}</p>
                </div>
                {category.children && category.children.length > 0 &&
                    <div className="open__children__categories" onClick={() => {
                        category.open_children = !category.open_children
                        setCategories((odd) => [
                            ...odd
                        ])
                    }}>
                        <ChevronDownIcon/>
                    </div>}
            </div>

            {category.open_children && category.children && category.children.length > 0 && <CategoryList
                setCategory={setCategory}
                setCategories={setCategories}
                categories={category.children}
                indent={indent + 20}
                selectedCategory={selectedCategory}
            />}
        </div>)}
    </div>)
}

const Catalog = () => {

    const [categories, setCategories] = useState([]);
    const [products, setProducts] = useState([]);

    const [orderBy, setOrderBy] = useState(orderAttributs[0]);
    const [selectedCategory, setSelectedCategory] = useState(false);

    const getProducts = () => {
        let params = {}
        if (orderBy.value !== "default")
            params.orderby = orderBy.value
        if (selectedCategory)
            params.category = selectedCategory
        api.get("products", params).then(({data}) => {
            if (orderBy.value === "default")
                setProducts(data.sort((a, b) => a.menu_order - b.menu_order))
            else
                setProducts(data)
        })
    }

    const setCategory = (category) => {
        if (!category) {
            setSelectedCategory(null)
            query.delete('category')
        } else {
            setSelectedCategory(category.id)
            query.set('category', category.slug)
        }

        if (history.pushState) {
            const newurl =
                window.location.protocol +
                "//" +
                window.location.host +
                window.location.pathname +
                (query.toString() ? "?" + query.toString() : "") +
                window.location.hash;
            window.history.replaceState({path: newurl}, "", newurl);
        }
    }

    const findRecursively = (data, slug) => {
        let u = null
        for (const c of data) {
            if (c.children)
                u = findRecursively(c.children, slug)
            if (c.slug == slug)
                return c
        }
        return u
    }

    const openRecursively = (category) => {
        if (category.parent_category) {
            category.parent_category.open_children = true
            openRecursively(category.parent_category)
        }
    }

    const restoreChild = (data) => {
        let i = 0

        const moveTo = (parent, child) => {
            parent.open_children = false
            if (!parent.children)
                parent.children = []
            parent.children.push(child)
            child.parent_category = parent
            parent.children = parent.children.sort((a, b) => a.menu_order - b.menu_order)
            data = data.filter(c => c.id != child.id)
        }

        while (i < data.length) {
            if (data[i].parent != 0) {
                const parent = data.find(c => c.id == data[i].parent)
                if (!parent) {
                    let e = 0
                    while (e < data.length) {
                        if (data[e].children) {
                            const parent = data[e].children.find(c => c.id == data[i].parent)
                            if (parent)
                                moveTo(parent, data[i])
                        }
                        e++;
                    }
                    break;
                } else {
                    moveTo(parent, data[i])
                    i = -1
                }
            }
            i++
        }

        let c = findRecursively(data, query.get('category'))
        if (c)
            openRecursively(c)


        return data
    }

    useEffect(() => {
        const category_slug = query.get("category");
        if (category_slug) {
            api.get('products/categories', {
                slug: category_slug
            }).then(({data}) => {
                setSelectedCategory(data[0].id)
            }).catch(e => {
                setCategory(null)
            })
        } else {
            setSelectedCategory(null)
        }
        api.get("products/categories").then(async ({data}) => {
            setCategories(restoreChild(data).sort((a, b) => a.menu_order - b.menu_order))
        });
    }, [])

    useEffect(() => {
        if (selectedCategory != false)
            getProducts()
    }, [selectedCategory, orderBy])


    return (<div className="catalog__grid">
        <div className="catalog__filters">
            <div className="catalog__orderby">
                <Listbox value={orderBy} onChange={setOrderBy}>
                    <Listbox.Button>{orderBy.label}</Listbox.Button>
                    <Listbox.Options>
                        {orderAttributs.map((attribute, i) => (
                            <Listbox.Option
                                key={i}
                                value={attribute}
                                disabled={attribute.value === orderBy.value}
                            >
                                {attribute.label}
                            </Listbox.Option>
                        ))}
                    </Listbox.Options>
                </Listbox>
            </div>
            <div className="catalog__categories">
                <h2>Catégories</h2>
                <CategoryList
                    setCategory={setCategory}
                    categories={categories}
                    selectedCategory={selectedCategory}
                    root={true}
                    indent={0}
                    setCategories={setCategories}
                />
            </div>
        </div>

        <div className="catalog__products">
            {products.length > 0 ? <>
                {products.map(product => <a href={product.permalink} className="catalog__product" key={product.id}>
                    {product.images.length > 0 ? <img src={product.images[0].src} alt={product.images[0].alt}/> : null}
                    <h2>{product.name}</h2>
                    <div className="short__description" dangerouslySetInnerHTML={{__html: product.short_description}}/>
                    <div className="bottom__product">
                        {product.stock_quantity && <div className="stock">{product.stock_quantity} en stock</div>}
                        <div className="price" dangerouslySetInnerHTML={{__html: product.price_html}}/>
                    </div>
                </a>)}
            </> : <div className="catalog__products__empty">Aucun produit</div>}
        </div>
    </div>)
}

export default Catalog;