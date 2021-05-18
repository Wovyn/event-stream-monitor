<?php
namespace Config;

class Aws extends \CodeIgniter\Config\BaseConfig {

    public $regions = [
        'us-east-2' => 'US East (Ohio)',
        'us-east-1' => 'US East (N. Virginia)',
        'us-west-1' => 'US West (N. California)',
        'us-west-2' => 'US West (Oregon)',
        'af-south-1' => 'Africa (Cape Town)',
        'ap-east-1' => 'Asia Pacific (Hong Kong)',
        'ap-south-1' => 'Asia Pacific (Mumbai)',
        'ap-northeast-3' => 'Asia Pacific (Osaka-Local)',
        'ap-northeast-2' => 'Asia Pacific (Seoul)',
        'ap-southeast-1' => 'Asia Pacific (Singapore)',
        'ap-southeast-2' => 'Asia Pacific (Sydney)',
        'ap-northeast-1' => 'Asia Pacific (Tokyo)',
        'ca-central-1' => 'Canada (Central)',
        'eu-central-1' => 'Europe (Frankfurt)',
        'eu-west-1' => 'Europe (Ireland)',
        'eu-west-2' => 'Europe (London)',
        'eu-south-1' => 'Europe (Milan)',
        'eu-west-3' => 'Europe (Paris)',
        'eu-north-1' => 'Europe (Stockholm)',
        'me-south-1' => 'Middle East (Bahrain)',
        'sa-east-1' => 'South America (São Paulo)'
    ];

    public $firehose_role_policy = [
        "Version" => "2012-10-17",
        "Statement" => [
            [
                "Sid" => "",
                "Effect" => "Allow",
                "Action" => [
                    "s3:AbortMultipartUpload",
                    "s3:GetBucketLocation",
                    "s3:GetObject",
                    "s3:ListBucket",
                    "s3:ListBucketMultipartUploads",
                    "s3:PutObject"
                ],
                "Resource" => [
                    "arn:aws:s3:::%bucket",
                    "arn:aws:s3:::%bucket/*"
                ]
            ],
            [
                "Sid" => "",
                "Effect" => "Allow",
                "Action" => [
                    "lambda:InvokeFunction",
                    "lambda:GetFunctionConfiguration"
                ],
                "Resource" => "arn:aws:lambda:%region:%account:function:%FIREHOSE_POLICY_TEMPLATE_PLACEHOLDER%"
            ],
            [
                "Effect" => "Allow",
                "Action" => [
                    "kms:GenerateDataKey",
                    "kms:Decrypt"
                ],
                "Resource" => [
                    "arn:aws:kms:%region:%account:key/%FIREHOSE_POLICY_TEMPLATE_PLACEHOLDER%"
                ],
                "Condition" => [
                    "StringEquals" => [
                        "kms:ViaService" => "s3.%region.amazonaws.com"
                    ],
                    "StringLike" => [
                        "kms:EncryptionContext:aws:s3:arn" => [
                            "arn:aws:s3:::%FIREHOSE_POLICY_TEMPLATE_PLACEHOLDER%/*"
                        ]
                    ]
                ]
            ],
            [
                "Sid" => "",
                "Effect" => "Allow",
                "Action" => [
                    "ec2:DescribeVpcs",
                    "ec2:DescribeVpcAttribute",
                    "ec2:DescribeSubnets",
                    "ec2:DescribeSecurityGroups",
                    "ec2:DescribeNetworkInterfaces",
                    "ec2:CreateNetworkInterface",
                    "ec2:CreateNetworkInterfacePermission",
                    "ec2:DeleteNetworkInterface"
                ],
                "Resource" => "*"
            ],
            [
                "Sid" => "",
                "Effect" => "Allow",
                "Action" => [
                    "es:DescribeElasticsearchDomain",
                    "es:DescribeElasticsearchDomains",
                    "es:DescribeElasticsearchDomainConfig",
                    "es:ESHttpPost",
                    "es:ESHttpPut"
                ],
                "Resource" => [
                    "arn:aws:es:%region:%account:domain/%domain",
                    "arn:aws:es:%region:%account:domain/%domain/*"
                ]
            ],
            [
                "Sid" => "",
                "Effect" => "Allow",
                "Action" => [
                    "es:ESHttpGet"
                ],
                "Resource" => [
                    "arn:aws:es:%region:%account:domain/%domain/_all/_settings",
                    "arn:aws:es:%region:%account:domain/%domain/_cluster/stats",
                    "arn:aws:es:%region:%account:domain/%domain/index/_mapping/%FIREHOSE_POLICY_TEMPLATE_PLACEHOLDER%",
                    "arn:aws:es:%region:%account:domain/%domain/_nodes",
                    "arn:aws:es:%region:%account:domain/%domain/_nodes/*/stats",
                    "arn:aws:es:%region:%account:domain/%domain/_stats",
                    "arn:aws:es:%region:%account:domain/%domain/index/_stats"
                ]
            ],
            [
                "Sid" => "",
                "Effect" => "Allow",
                "Action" => [
                    "logs:PutLogEvents"
                ],
                "Resource" => [
                    "arn:aws:logs:%region:%account:log-group:/aws/kinesisfirehose/%delivery:log-stream:*"
                ]
            ],
            [
                "Sid" => "",
                "Effect" => "Allow",
                "Action" => [
                    "kinesis:DescribeStream",
                    "kinesis:GetShardIterator",
                    "kinesis:GetRecords",
                    "kinesis:ListShards"
                ],
                "Resource" => "arn:aws:kinesis:%region:%account:stream/%stream"
            ],
            [
                "Effect" => "Allow",
                "Action" => [
                    "kms:Decrypt"
                ],
                "Resource" => [
                    "arn:aws:kms:%region:%account:key/%FIREHOSE_POLICY_TEMPLATE_PLACEHOLDER%"
                ],
                "Condition" => [
                    "StringEquals" => [
                        "kms:ViaService" => "kinesis.%region.amazonaws.com"
                    ],
                    "StringLike" => [
                        "kms:EncryptionContext:aws:kinesis:arn" => "arn:aws:kinesis:%region:%account:stream/%stream"
                    ]
                ]
            ]

        ]
    ];
}