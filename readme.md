# Simple Blockchain in PHP

This application is a very simple PHP execution of a blockchain within Laravel's Lumen framework. Chains and blocks are stored in the storage filesystem as JSON files and objects. Create a chain, generate blocks and validate chains.
-- Phillip Roth (wwwroth)

## Usage

#### Create a chain

Creating a chain will return a SHA256 hash for the directory your blocks will be placed in. By default, chain directories will be located in a *storage/app/chains*. 

```
$ php artisan blockchain:create-chain  
                                                                                         
Chain created: 17c3a3048dff2462326e9fb2039efd15182e62d8cf31375d45de52eb21e14cb7c 
```

#### Create blocks inside a chain

Creating blocks inside a chain will created a new JSON file for each block in succession. Provide the chainId from the create-chain command and the amount of blocks with the --numBlocks option or it will default to one.

```
$ php artisan blockchain:create-block 
    --chainId=7c3a3048dff2462326e9fb2039efd15182e62d8cf31375d45de52eb21e14cb7c          
    --numBlocks=3     
    
Block created: {"microtime":"0.01119800 1537293365","data":{"start":64721,"end":97739},"previousHash":0,"index":0,"hash":"19d299c97af9be197e19d7686a65a922f75044c2e00c43e99b6fd22ece06044d"}
Block created: {"microtime":"0.01192100 1537293365","data":{"start":11234,"end":46966},"previousHash":"19d299c97af9be197e19d7686a65a922f75044c2e00c43e99b6fd22ece06044d","index":1,"hash":"9c4df2822a0ed8c7d487747ff3978895bdb01dfb907123006ce88d6733d5f68d"}
Block created: {"microtime":"0.01253600 1537293365","data":{"start":78400,"end":21388},"previousHash":"9c4df2822a0ed8c7d487747ff3978895bdb01dfb907123006ce88d6733d5f68d","index":2,"hash":"3463d818b165ad06f03ef638d6784bb3fe76b50f50b6a0fc3452d154024083c4"}                                                                               
```

#### Validate a chain

To validate blocks in a chain, use the following command. Each block that is valid will return a message and the script will hault with an error if we come across in invalid block.
```
$ php artisan blockchain:validate-chain 
    --id=7c3a3048dff2462326e9fb2039efd15182e62d8cf31375d45de52eb21e14cb7c
    
Block 0 valid.
Block 1 valid.
Block 2 valid.
Block 3 valid.
Block 4 valid.
Block 5 is invalid. Chain broken.                                                                    
```

#### Deleting chains

You can delete a chains in the filesystem by specifying an id. 
```
$ php artisan blockchain:delete-chain --id=1b47ba5d19927487f624e1e455085aa2ae76c91f2abb3a6fd255adb107325c05
 
chains/1b47ba5d19927487f624e1e455085aa2ae76c91f2abb3a6fd255adb107325c05 deleted.
```

You can delete all chains in the filesystem by not specifying an id. 
```
$ php artisan blockchain:delete-chain
 
chains/1b47ba5d19927487f624e1e455085aa2ae76c91f2abb3a6fd255adb107325c05 deleted.
chains/7c3a3048dff2462326e9fb2039efd15182e62d8cf31375d45de52eb21e14cb7c deleted.
chains/9c8372b93063c0d1f87614f10dca4cbd0d700a9b4734462f64a2d2ed76bfd5aa deleted.
```