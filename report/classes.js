var classes = [
    {
        "name": "Models\\Log",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "add",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getAll",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "filter",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getStats",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "clearOld",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "clearAll",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 7,
        "nbMethods": 7,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 7,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 27,
        "ccn": 21,
        "ccnMethodMax": 10,
        "externals": [
            "Database"
        ],
        "parents": [],
        "implements": [],
        "lcom": 1,
        "length": 248,
        "vocabulary": 73,
        "volume": 1535.08,
        "difficulty": 18.49,
        "effort": 28386.33,
        "level": 0.05,
        "bugs": 0.51,
        "time": 1577,
        "intelligentContent": 83.01,
        "number_operators": 60,
        "number_operands": 188,
        "number_operators_unique": 12,
        "number_operands_unique": 61,
        "cloc": 2,
        "loc": 105,
        "lloc": 103,
        "mi": 41.57,
        "mIwoC": 30.96,
        "commentWeight": 10.61,
        "kanDefect": 1.63,
        "relativeStructuralComplexity": 121,
        "relativeDataComplexity": 0.69,
        "relativeSystemComplexity": 121.69,
        "totalStructuralComplexity": 847,
        "totalDataComplexity": 4.83,
        "totalSystemComplexity": 851.83,
        "package": "Models\\",
        "pageRank": 0.25,
        "afferentCoupling": 0,
        "efferentCoupling": 1,
        "instability": 1,
        "violations": {}
    },
    {
        "name": "Models\\Order",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getAllOrders",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getUserOrders",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "saveOrder",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getOrderById",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 5,
        "nbMethods": 5,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 5,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 19,
        "ccn": 15,
        "ccnMethodMax": 9,
        "externals": [],
        "parents": [],
        "implements": [],
        "lcom": 1,
        "length": 84,
        "vocabulary": 27,
        "volume": 399.41,
        "difficulty": 8.93,
        "effort": 3564.74,
        "level": 0.11,
        "bugs": 0.13,
        "time": 198,
        "intelligentContent": 44.75,
        "number_operators": 33,
        "number_operands": 51,
        "number_operators_unique": 7,
        "number_operands_unique": 20,
        "cloc": 0,
        "loc": 56,
        "lloc": 56,
        "mi": 41.63,
        "mIwoC": 41.63,
        "commentWeight": 0,
        "kanDefect": 1.03,
        "relativeStructuralComplexity": 1,
        "relativeDataComplexity": 3.3,
        "relativeSystemComplexity": 4.3,
        "totalStructuralComplexity": 5,
        "totalDataComplexity": 16.5,
        "totalSystemComplexity": 21.5,
        "package": "Models\\",
        "pageRank": 0.25,
        "afferentCoupling": 0,
        "efferentCoupling": 0,
        "instability": 0,
        "violations": {}
    },
    {
        "name": "Models\\Product",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "loadData",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getById",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getBasketData",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "saveData",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "updateProduct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "addProduct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "prepareData",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 8,
        "nbMethods": 8,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 8,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 47,
        "ccn": 40,
        "ccnMethodMax": 12,
        "externals": [
            "Database"
        ],
        "parents": [],
        "implements": [],
        "lcom": 2,
        "length": 380,
        "vocabulary": 92,
        "volume": 2478.95,
        "difficulty": 18.35,
        "effort": 45497.87,
        "level": 0.05,
        "bugs": 0.83,
        "time": 2528,
        "intelligentContent": 135.07,
        "number_operators": 79,
        "number_operands": 301,
        "number_operators_unique": 10,
        "number_operands_unique": 82,
        "cloc": 7,
        "loc": 107,
        "lloc": 100,
        "mi": 46.52,
        "mIwoC": 27.23,
        "commentWeight": 19.3,
        "kanDefect": 1.56,
        "relativeStructuralComplexity": 49,
        "relativeDataComplexity": 1.22,
        "relativeSystemComplexity": 50.22,
        "totalStructuralComplexity": 392,
        "totalDataComplexity": 9.75,
        "totalSystemComplexity": 401.75,
        "package": "Models\\",
        "pageRank": 0.25,
        "afferentCoupling": 0,
        "efferentCoupling": 1,
        "instability": 1,
        "violations": {}
    },
    {
        "name": "Models\\User",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "loadUsers",
                "role": null,
                "public": false,
                "private": true,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "saveUsers",
                "role": null,
                "public": false,
                "private": true,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "create",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "findByEmail",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "findById",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getAllUsers",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "deleteUser",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "setRole",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "verifyUser",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "updatePhone",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "updatePassword",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "updateCard",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "verifyPassword",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 14,
        "nbMethods": 14,
        "nbMethodsPrivate": 2,
        "nbMethodsPublic": 12,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 21,
        "ccn": 8,
        "ccnMethodMax": 3,
        "externals": [
            "Database"
        ],
        "parents": [],
        "implements": [],
        "lcom": 2,
        "length": 169,
        "vocabulary": 46,
        "volume": 933.48,
        "difficulty": 9.83,
        "effort": 9171.46,
        "level": 0.1,
        "bugs": 0.31,
        "time": 510,
        "intelligentContent": 95.01,
        "number_operators": 38,
        "number_operands": 131,
        "number_operators_unique": 6,
        "number_operands_unique": 40,
        "cloc": 2,
        "loc": 96,
        "lloc": 94,
        "mi": 46.17,
        "mIwoC": 35.09,
        "commentWeight": 11.09,
        "kanDefect": 0.36,
        "relativeStructuralComplexity": 49,
        "relativeDataComplexity": 1.91,
        "relativeSystemComplexity": 50.91,
        "totalStructuralComplexity": 686,
        "totalDataComplexity": 26.75,
        "totalSystemComplexity": 712.75,
        "package": "Models\\",
        "pageRank": 0.25,
        "afferentCoupling": 0,
        "efferentCoupling": 1,
        "instability": 1,
        "violations": {}
    }
]