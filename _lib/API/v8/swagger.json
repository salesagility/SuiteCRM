{
  "swagger": "3.0",
  "info": {
    "version": "8.0.0",
    "title": "SuiteCRM REST API (JSON API v1.0.0)",
    "contact": {
      "name": "Support",
      "url": "https://suitecrm.com/forum"
    },
    "description": "",
    "license": {
      "name": "GNU AFFERO GENERAL PUBLIC LICENSE VERSION 3",
      "url": "https://github.com/salesagility/SuiteCRM/blob/master/LICENSE.txt"
    }
  },
  "paths": {
    "/api/v8/modules/viewed": {
      "get": {
        "summary": "List recently viewed records",
        "description": "List recently viewed records of the currently logged in user for all modules",
        "responses": {
          "200" : {
            "description": "successful result",
            "headers":[
              {"Content-Type": "application/json"},
              {"Accept": "application/json"}
            ]
          }
        }
      }
    },
    "/api/v8/modules/favorite": {
      "get": {
        "summary": "List favorite records",
        "description": "List favorite records of the currently logged in user for all modules"
      }
    },
    "/api/v8/modules/meta/list": {
      "get": {
        "summary": "List available modules modules",
        "description": "",
        "responses": {
          "200" : {
            "description": "success login",
            "headers":[
              {"Content-Type": "application/json"},
              {"Accept": "application/json"}
            ]
          }
        }
      }
    },
    "/api/v8/modules/meta/menu/modules": {
      "get": {
        "summary": "List modules menu (non-filter)",
        "description": "Get the list of modules with their actions"
      }
    },
    "/api/v8/modules/meta/menu/filters": {
      "get": {
        "summary": "List modules menu (filter)",
        "description": "Get the list of filters"
      }
    },
    "/api/v8/modules/{module}": {
      "get": {
        "summary": "List records for a single module",
        "description": "List a paginated list of records for a single module",
        "responses": {}
      },
      "post": {
        "summary": "Create module record",
        "description": "Create a record for a single module",
        "responses": {}
      }
    },
    "/api/v8/modules/{module}/viewed": {
      "get": {
        "summary": "List recently viewed records (module)",
        "description": "List recently viewed records of the currently logged in user for a single module",
        "responses": {}
      }
    },
    "/api/v8/modules/{module}/favorites": {
      "get": {
        "summary": "List favorite records (module)",
        "description": "List favorite records of the currently logged in user for a single module",
        "responses": {}
      }
    },
    "/api/v8/modules/{modules}/meta/language": {
      "get": {
        "summary": "List available modules modules",
        "description": "",
        "responses": {
          "200" : {
            "description": "success login",
            "headers":[
              {"Content-Type": "application/json"},
              {"Accept": "application/json"}
            ]
          }
        }
      }
    },
    "/api/v8/modules/{modules}/meta/attributes": {
      "get": {
        "summary": "List modules menu (non-filter)",
        "description": "Get the list of modules with their actions"
      }
    },
    "/api/v8/modules/{modules}/meta/menu": {
      "get": {
        "summary": "List modules menu (filter)",
        "description": "Get the list of filters"
      }
    },
    "/api/v8/modules/{modules}/meta/view": {
      "get": {
        "summary": "List modules menu (filter)",
        "description": "Get the list of filters"
      }
    },
    "/api/v8/modules/{modules}/{id}": {
      "get": {
        "summary": "List modules menu (filter)",
        "description": "Get the list of filters"
      }
    },
    "/api/v8/modules/{modules}/{id}/relationships/{link}": {
      "get": {
        "summary": "List modules menu (filter)",
        "description": "Get the list of filters"
      }
    }
  },
  "securityDefinitions": {
    "suitecrm_api_auth": {
      "type": "oauth2",
      "flow": {
        "password": {
          "authorizationUrl": "/oauth/access_token",
          "in": "header",
          "scheme": "http",
          "bearerFormat": "bearer",
          "scopes": {
            "admin:access": "access to the administrative operations",
            "standard:create": "standard user can create records",
            "standard:read": "standard user can read records",
            "standard:update": "standard user can update records",
            "standard:delete": "standard user can delete records",
            "standard:meta": "standard user can access meta information",
            "standard:relationship:create": "standard user can create relationship links",
            "standard:relationship:read": "standard user can read relationship links",
            "standard:relationship:update": "standard user can update relationship links",
            "standard:relationship:delete": "standard user can delete relationship links"
          }
        }
      }
    }
  },
  "components": {
    "schemas": {
      "success": {
        "required": [
          "type",
          "required",
          "properties",
          "additionalProperties"
        ],
        "properties": {
          "type": {
            "type": "string"
          },
          "required": {
            "type": "array",
            "items": {
              "type": "string"
            }
          },
          "properties": {
            "required": [
              "data",
              "included",
              "meta",
              "links",
              "jsonapi"
            ],
            "properties": {
              "data": {
                "required": [
                  "$ref"
                ],
                "properties": {
                  "$ref": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "included": {
                "required": [
                  "description",
                  "type",
                  "items",
                  "uniqueItems"
                ],
                "properties": {
                  "description": {
                    "type": "string"
                  },
                  "type": {
                    "type": "string"
                  },
                  "items": {
                    "required": [
                      "$ref"
                    ],
                    "properties": {
                      "$ref": {
                        "type": "string"
                      }
                    },
                    "type": "object"
                  },
                  "uniqueItems": {
                    "type": "boolean"
                  }
                },
                "type": "object"
              },
              "meta": {
                "required": [
                  "$ref"
                ],
                "properties": {
                  "$ref": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "links": {
                "required": [
                  "description",
                  "allOf"
                ],
                "properties": {
                  "description": {
                    "type": "string"
                  },
                  "allOf": {
                    "type": "array",
                    "items": {
                      "type": "object",
                      "properties": {
                        "$ref": {
                          "type": "string"
                        }
                      }
                    }
                  }
                },
                "type": "object"
              },
              "jsonapi": {
                "required": [
                  "$ref"
                ],
                "properties": {
                  "$ref": {
                    "type": "string"
                  }
                },
                "type": "object"
              }
            },
            "type": "object"
          },
          "additionalProperties": {
            "type": "boolean"
          }
        },
        "type": "object"
      },
      "failure": {
        "required": [
          "type",
          "required",
          "properties",
          "additionalProperties"
        ],
        "properties": {
          "type": {
            "type": "string"
          },
          "required": {
            "type": "array",
            "items": {
              "type": "string"
            }
          },
          "properties": {
            "required": [
              "errors",
              "meta",
              "jsonapi",
              "links"
            ],
            "properties": {
              "errors": {
                "required": [
                  "type",
                  "items",
                  "uniqueItems"
                ],
                "properties": {
                  "type": {
                    "type": "string"
                  },
                  "items": {
                    "required": [
                      "$ref"
                    ],
                    "properties": {
                      "$ref": {
                        "type": "string"
                      }
                    },
                    "type": "object"
                  },
                  "uniqueItems": {
                    "type": "boolean"
                  }
                },
                "type": "object"
              },
              "meta": {
                "required": [
                  "$ref"
                ],
                "properties": {
                  "$ref": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "jsonapi": {
                "required": [
                  "$ref"
                ],
                "properties": {
                  "$ref": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "links": {
                "required": [
                  "$ref"
                ],
                "properties": {
                  "$ref": {
                    "type": "string"
                  }
                },
                "type": "object"
              }
            },
            "type": "object"
          },
          "additionalProperties": {
            "type": "boolean"
          }
        },
        "type": "object"
      },
      "info": {
        "required": [
          "type",
          "required",
          "properties",
          "additionalProperties"
        ],
        "properties": {
          "type": {
            "type": "string"
          },
          "required": {
            "type": "array",
            "items": {
              "type": "string"
            }
          },
          "properties": {
            "required": [
              "meta",
              "links",
              "jsonapi"
            ],
            "properties": {
              "meta": {
                "required": [
                  "$ref"
                ],
                "properties": {
                  "$ref": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "links": {
                "required": [
                  "$ref"
                ],
                "properties": {
                  "$ref": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "jsonapi": {
                "required": [
                  "$ref"
                ],
                "properties": {
                  "$ref": {
                    "type": "string"
                  }
                },
                "type": "object"
              }
            },
            "type": "object"
          },
          "additionalProperties": {
            "type": "boolean"
          }
        },
        "type": "object"
      },
      "meta": {
        "required": [
          "description",
          "type",
          "additionalProperties"
        ],
        "properties": {
          "description": {
            "type": "string"
          },
          "type": {
            "type": "string"
          },
          "additionalProperties": {
            "type": "boolean"
          }
        },
        "type": "object"
      },
      "data": {
        "required": [
          "description",
          "oneOf"
        ],
        "properties": {
          "description": {
            "type": "string"
          },
          "oneOf": {
            "type": "array",
            "items": {
              "type": "object",
              "properties": {
                "description": {
                  "type": "string"
                },
                "type": {
                  "type": "string"
                },
                "items": {
                  "required": [
                    "$ref"
                  ],
                  "properties": {
                    "$ref": {
                      "type": "string"
                    }
                  },
                  "type": "object"
                },
                "uniqueItems": {
                  "type": "boolean"
                }
              }
            }
          }
        },
        "type": "object"
      },
      "resource": {
        "required": [
          "description",
          "type",
          "required",
          "properties",
          "additionalProperties"
        ],
        "properties": {
          "description": {
            "type": "string"
          },
          "type": {
            "type": "string"
          },
          "required": {
            "type": "array",
            "items": {
              "type": "string"
            }
          },
          "properties": {
            "required": [
              "type",
              "id",
              "attributes",
              "relationships",
              "links",
              "meta"
            ],
            "properties": {
              "type": {
                "required": [
                  "type"
                ],
                "properties": {
                  "type": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "id": {
                "required": [
                  "type"
                ],
                "properties": {
                  "type": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "attributes": {
                "required": [
                  "$ref"
                ],
                "properties": {
                  "$ref": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "relationships": {
                "required": [
                  "$ref"
                ],
                "properties": {
                  "$ref": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "links": {
                "required": [
                  "$ref"
                ],
                "properties": {
                  "$ref": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "meta": {
                "required": [
                  "$ref"
                ],
                "properties": {
                  "$ref": {
                    "type": "string"
                  }
                },
                "type": "object"
              }
            },
            "type": "object"
          },
          "additionalProperties": {
            "type": "boolean"
          }
        },
        "type": "object"
      },
      "relationshipLinks": {
        "required": [
          "description",
          "type",
          "properties",
          "additionalProperties"
        ],
        "properties": {
          "description": {
            "type": "string"
          },
          "type": {
            "type": "string"
          },
          "properties": {
            "required": [
              "self",
              "related"
            ],
            "properties": {
              "self": {
                "required": [
                  "description",
                  "$ref"
                ],
                "properties": {
                  "description": {
                    "type": "string"
                  },
                  "$ref": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "related": {
                "required": [
                  "$ref"
                ],
                "properties": {
                  "$ref": {
                    "type": "string"
                  }
                },
                "type": "object"
              }
            },
            "type": "object"
          },
          "additionalProperties": {
            "type": "boolean"
          }
        },
        "type": "object"
      },
      "links": {
        "required": [
          "type",
          "additionalProperties"
        ],
        "properties": {
          "type": {
            "type": "string"
          },
          "additionalProperties": {
            "required": [
              "$ref"
            ],
            "properties": {
              "$ref": {
                "type": "string"
              }
            },
            "type": "object"
          }
        },
        "type": "object"
      },
      "link": {
        "required": [
          "description",
          "oneOf"
        ],
        "properties": {
          "description": {
            "type": "string"
          },
          "oneOf": {
            "type": "array",
            "items": {
              "type": "object",
              "properties": {
                "description": {
                  "type": "string"
                },
                "type": {
                  "type": "string"
                },
                "format": {
                  "type": "string"
                }
              }
            }
          }
        },
        "type": "object"
      },
      "attributes": {
        "required": [
          "description",
          "type",
          "patternProperties",
          "additionalProperties"
        ],
        "properties": {
          "description": {
            "type": "string"
          },
          "type": {
            "type": "string"
          },
          "patternProperties": {
            "required": [
              "^(?!relationships$|links$|id$|type$)\\w[-\\w_]*$"
            ],
            "properties": {
              "^(?!relationships$|links$|id$|type$)\\w[-\\w_]*$": {
                "required": [
                  "description"
                ],
                "properties": {
                  "description": {
                    "type": "string"
                  }
                },
                "type": "object"
              }
            },
            "type": "object"
          },
          "additionalProperties": {
            "type": "boolean"
          }
        },
        "type": "object"
      },
      "relationships": {
        "required": [
          "description",
          "type",
          "patternProperties",
          "additionalProperties"
        ],
        "properties": {
          "description": {
            "type": "string"
          },
          "type": {
            "type": "string"
          },
          "patternProperties": {
            "required": [
              "^(?!id$|type$)\\w[-\\w_]*$"
            ],
            "properties": {
              "^(?!id$|type$)\\w[-\\w_]*$": {
                "required": [
                  "properties",
                  "anyOf",
                  "additionalProperties"
                ],
                "properties": {
                  "properties": {
                    "required": [
                      "links",
                      "data",
                      "meta"
                    ],
                    "properties": {
                      "links": {
                        "required": [
                          "$ref"
                        ],
                        "properties": {
                          "$ref": {
                            "type": "string"
                          }
                        },
                        "type": "object"
                      },
                      "data": {
                        "required": [
                          "description",
                          "oneOf"
                        ],
                        "properties": {
                          "description": {
                            "type": "string"
                          },
                          "oneOf": {
                            "type": "array",
                            "items": {
                              "type": "object",
                              "properties": {
                                "$ref": {
                                  "type": "string"
                                }
                              }
                            }
                          }
                        },
                        "type": "object"
                      },
                      "meta": {
                        "required": [
                          "$ref"
                        ],
                        "properties": {
                          "$ref": {
                            "type": "string"
                          }
                        },
                        "type": "object"
                      }
                    },
                    "type": "object"
                  },
                  "anyOf": {
                    "type": "array",
                    "items": {
                      "type": "object",
                      "properties": {
                        "required": {
                          "type": "array",
                          "items": {
                            "type": "string"
                          }
                        }
                      }
                    }
                  },
                  "additionalProperties": {
                    "type": "boolean"
                  }
                },
                "type": "object"
              }
            },
            "type": "object"
          },
          "additionalProperties": {
            "type": "boolean"
          }
        },
        "type": "object"
      },
      "relationshipToOne": {
        "required": [
          "description",
          "anyOf"
        ],
        "properties": {
          "description": {
            "type": "string"
          },
          "anyOf": {
            "type": "array",
            "items": {
              "type": "object",
              "properties": {
                "$ref": {
                  "type": "string"
                }
              }
            }
          }
        },
        "type": "object"
      },
      "relationshipToMany": {
        "required": [
          "description",
          "type",
          "items",
          "uniqueItems"
        ],
        "properties": {
          "description": {
            "type": "string"
          },
          "type": {
            "type": "string"
          },
          "items": {
            "required": [
              "$ref"
            ],
            "properties": {
              "$ref": {
                "type": "string"
              }
            },
            "type": "object"
          },
          "uniqueItems": {
            "type": "boolean"
          }
        },
        "type": "object"
      },
      "empty": {
        "required": [
          "description",
          "type"
        ],
        "properties": {
          "description": {
            "type": "string"
          },
          "type": {
            "type": "string"
          }
        },
        "type": "object"
      },
      "linkage": {
        "required": [
          "description",
          "type",
          "required",
          "properties",
          "additionalProperties"
        ],
        "properties": {
          "description": {
            "type": "string"
          },
          "type": {
            "type": "string"
          },
          "required": {
            "type": "array",
            "items": {
              "type": "string"
            }
          },
          "properties": {
            "required": [
              "type",
              "id",
              "meta"
            ],
            "properties": {
              "type": {
                "required": [
                  "type"
                ],
                "properties": {
                  "type": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "id": {
                "required": [
                  "type"
                ],
                "properties": {
                  "type": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "meta": {
                "required": [
                  "$ref"
                ],
                "properties": {
                  "$ref": {
                    "type": "string"
                  }
                },
                "type": "object"
              }
            },
            "type": "object"
          },
          "additionalProperties": {
            "type": "boolean"
          }
        },
        "type": "object"
      },
      "pagination": {
        "required": [
          "type",
          "properties"
        ],
        "properties": {
          "type": {
            "type": "string"
          },
          "properties": {
            "required": [
              "first",
              "last",
              "prev",
              "next"
            ],
            "properties": {
              "first": {
                "required": [
                  "description",
                  "oneOf"
                ],
                "properties": {
                  "description": {
                    "type": "string"
                  },
                  "oneOf": {
                    "type": "array",
                    "items": {
                      "type": "object",
                      "properties": {
                        "type": {
                          "type": "string"
                        },
                        "format": {
                          "type": "string"
                        }
                      }
                    }
                  }
                },
                "type": "object"
              },
              "last": {
                "required": [
                  "description",
                  "oneOf"
                ],
                "properties": {
                  "description": {
                    "type": "string"
                  },
                  "oneOf": {
                    "type": "array",
                    "items": {
                      "type": "object",
                      "properties": {
                        "type": {
                          "type": "string"
                        },
                        "format": {
                          "type": "string"
                        }
                      }
                    }
                  }
                },
                "type": "object"
              },
              "prev": {
                "required": [
                  "description",
                  "oneOf"
                ],
                "properties": {
                  "description": {
                    "type": "string"
                  },
                  "oneOf": {
                    "type": "array",
                    "items": {
                      "type": "object",
                      "properties": {
                        "type": {
                          "type": "string"
                        },
                        "format": {
                          "type": "string"
                        }
                      }
                    }
                  }
                },
                "type": "object"
              },
              "next": {
                "required": [
                  "description",
                  "oneOf"
                ],
                "properties": {
                  "description": {
                    "type": "string"
                  },
                  "oneOf": {
                    "type": "array",
                    "items": {
                      "type": "object",
                      "properties": {
                        "type": {
                          "type": "string"
                        },
                        "format": {
                          "type": "string"
                        }
                      }
                    }
                  }
                },
                "type": "object"
              }
            },
            "type": "object"
          }
        },
        "type": "object"
      },
      "jsonapi": {
        "required": [
          "description",
          "type",
          "properties",
          "additionalProperties"
        ],
        "properties": {
          "description": {
            "type": "string"
          },
          "type": {
            "type": "string"
          },
          "properties": {
            "required": [
              "version",
              "meta"
            ],
            "properties": {
              "version": {
                "required": [
                  "type"
                ],
                "properties": {
                  "type": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "meta": {
                "required": [
                  "$ref"
                ],
                "properties": {
                  "$ref": {
                    "type": "string"
                  }
                },
                "type": "object"
              }
            },
            "type": "object"
          },
          "additionalProperties": {
            "type": "boolean"
          }
        },
        "type": "object"
      },
      "error": {
        "required": [
          "type",
          "properties",
          "additionalProperties"
        ],
        "properties": {
          "type": {
            "type": "string"
          },
          "properties": {
            "required": [
              "id",
              "links",
              "status",
              "code",
              "title",
              "detail",
              "source",
              "meta"
            ],
            "properties": {
              "id": {
                "required": [
                  "description",
                  "type"
                ],
                "properties": {
                  "description": {
                    "type": "string"
                  },
                  "type": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "links": {
                "required": [
                  "$ref"
                ],
                "properties": {
                  "$ref": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "status": {
                "required": [
                  "description",
                  "type"
                ],
                "properties": {
                  "description": {
                    "type": "string"
                  },
                  "type": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "code": {
                "required": [
                  "description",
                  "type"
                ],
                "properties": {
                  "description": {
                    "type": "string"
                  },
                  "type": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "title": {
                "required": [
                  "description",
                  "type"
                ],
                "properties": {
                  "description": {
                    "type": "string"
                  },
                  "type": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "detail": {
                "required": [
                  "description",
                  "type"
                ],
                "properties": {
                  "description": {
                    "type": "string"
                  },
                  "type": {
                    "type": "string"
                  }
                },
                "type": "object"
              },
              "source": {
                "required": [
                  "type",
                  "properties"
                ],
                "properties": {
                  "type": {
                    "type": "string"
                  },
                  "properties": {
                    "required": [
                      "pointer",
                      "parameter"
                    ],
                    "properties": {
                      "pointer": {
                        "required": [
                          "description",
                          "type"
                        ],
                        "properties": {
                          "description": {
                            "type": "string"
                          },
                          "type": {
                            "type": "string"
                          }
                        },
                        "type": "object"
                      },
                      "parameter": {
                        "required": [
                          "description",
                          "type"
                        ],
                        "properties": {
                          "description": {
                            "type": "string"
                          },
                          "type": {
                            "type": "string"
                          }
                        },
                        "type": "object"
                      }
                    },
                    "type": "object"
                  }
                },
                "type": "object"
              },
              "meta": {
                "required": [
                  "$ref"
                ],
                "properties": {
                  "$ref": {
                    "type": "string"
                  }
                },
                "type": "object"
              }
            },
            "type": "object"
          },
          "additionalProperties": {
            "type": "boolean"
          }
        },
        "type": "object"
      }
    }
  }
}