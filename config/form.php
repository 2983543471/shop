<?php
return [
	// 是否开启令牌验证
	'TOKEN_ON'    => true,
	// 令牌验证的表单隐藏字段名称
	'TOKEN_NAME'  => '__token__',
	//令牌哈希验证规则 默认为MD5
	'TOKEN_TYPE'  => 'md5',
	//令牌验证出错后是否重置令牌 默认为true
	'TOKEN_RESET' => true,
];