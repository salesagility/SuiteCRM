<?php
namespace Api\V8\Exception;

class BeanNotFoundException extends NotFoundException
{
    const CODE_BY_ID = 1;
    const CODE_BY_RELATION = 2;
}
