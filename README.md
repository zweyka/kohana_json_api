# JSON API module for Kohana
Test by KoSeven: https://github.com/koseven/koseven

Module для Kohana помогающий в реализации JSON API.

It has a single point of entry.<br />
Receives requests using the POST method.

### Requests
```
page = {
    size: 30 // limit
    number: 2 // page number. For offset
    published_at: 1538332156 // the cursor paginate
},
fields: 'title, name, description',
filters: {
    search: 'text for search' // text for search
    from_date: 1538332156 // from time
    is_published: true // only published
    author => 2 // by author
},
sort: 'author,-publisbed' // sorting by author ASC and publisbed DESC 
```
You can specify the required dependencies
```
relation: 'category, seller'
```
or, add collation for dependencies
```
relation: {
    seller: {
        fields: 'name, rating, date_reg',
        filters: {
            is_published: true,
        },
    ]
}
```
### Response
```
{
    data: {
        {
            type: 'posts',
            id: 12,
            attributes: {
                name: 'Title',
                price: 1200,
                seller: 30
            },
            included: {
                category: {
                    type: 'category', 
                    id: 41
                }
                seller: {
                    type: 'seller',
                    id: 93
                }
            }
        }    
    }
    included: {
        category: {
            {
                type: 'category',
                id: 41,
                attributes: {
                    title: 'Category title'
                }
            }
        }
        seller: {
            {
                type: 'seller',
                id: 93,
                attributes: {
                    name: 'Seller name',
                    rating: 15,
                    date_reg: '2019-03-18 09:17:07'
                }
            }
        }
    }
    errors: {}
}
```
## Authors

* [**Aleksandr Zwey**](https://github.com/zweyka)